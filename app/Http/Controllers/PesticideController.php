<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesticide;
use App\Http\Requests\Pesticide\StorePesticideRequest;
use App\Http\Requests\Pesticide\UpdatePesticideRequest;

class PesticideController extends Controller
{
    private $tableName = 'pesticides';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Pesticide/Index', [
            'response' => $this->getData($request),
            'search' => $request->search ?? '',
            'order' => [
                'orderBy' => $request->orderBy ?? 'id',
                'orderType' => $request->orderType ?? 'desc'
            ]
        ]);
    }

            /**
     * Get data from database
     */
    private function getData($request)
    {
        $query = Pesticide::orderBy($this->tableName . '.' . ($request->orderBy ?? 'id'), $request->orderType ?? 'desc')

        ->when($request->search != '', function ($query) use ($request) {
                return $query->orWhere($this->tableName . '.name', 'like', '%' . $request->search . '%');
        })

        ->paginate($request->perPage ?? 10);

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pesticide/Create', [
            //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePesticideRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            Pesticide::create($validated);
            DB::commit();
            return back();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesticide $pesticide)
    {
        return Inertia::render('Pesticide/Show', [
            'model' => $pesticide
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesticide $pesticide)
    {
        return Inertia::render('Pesticide/Edit', [
            'model' => $pesticide
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePesticideRequest $request, Pesticide $pesticide)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $pesticide->update($validated);
            DB::commit();
            return back();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesticide $pesticide)
    {
        if(!empty($request->id_array) && is_array($request->id_array)) {
            DB::beginTransaction();
            try {
                Pesticide::destroy($request->id_array);
                DB::commit();
                return back();
            } catch (Throwable $e) {
                DB::rollBack();
                return $e;
            }
        }
    }
}
