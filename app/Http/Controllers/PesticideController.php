<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesticide;
use App\Http\Requests\Pesticide\StorePesticideRequest;
use App\Http\Requests\Pesticide\UpdatePesticideRequest;
use App\Models\PestType;

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
        $query = Pesticide::with('pest_types')
        ->orderBy($this->tableName . '.' . ($request->orderBy ?? 'id'), $request->orderType ?? 'desc')

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
            'pest_types' => PestType::all('id', 'name'),
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
            $pesticide = Pesticide::create($validated);

            // Attach pest_types
            foreach ($validated['pest_types'] as $pest_type) {
                $pesticide->pest_types()->attach($pest_type['id']);
            }

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
            'model' => $pesticide->load('pest_types')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesticide $pesticide)
    {
        return Inertia::render('Pesticide/Edit', [
            'model' => $pesticide->load('pest_types'),
            'pest_types' => PestType::all('id', 'name'),
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

            // Detach all pest_types
            $pesticide->pest_types()->detach();

            // Attach pest_types
            foreach ($validated['pest_types'] as $pest_type) {
                $pesticide->pest_types()->attach($pest_type['id']);
            }

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
    public function destroy(Request $request)
    {
        if(!empty($request->id_array) && is_array($request->id_array)) {
            DB::beginTransaction();
            try {
                // $pestTypes = PestType::whereIn('pesticide_id', $request->id_array)->get();

                // if (count($pestTypes) > 0) {
                //     return back()->withErrors([
                //         'Cannot delete Pesticide with associated Pest Type.'
                //     ]);
                // }

                DB::table('pesticide_pest_type')
                ->whereIn('pesticide_id', $request->id_array)
                ->delete();

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
