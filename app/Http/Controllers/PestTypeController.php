<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use App\Models\PestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PestType\StorePestTypeRequest;
use App\Http\Requests\PestType\UpdatePestTypeRequest;

class PestTypeController extends Controller
{
    private $tableName = 'pest_types';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('PestType/Index', [
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
        $query = PestType::orderBy($this->tableName . '.' . ($request->orderBy ?? 'id'), $request->orderType ?? 'desc')

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
        return Inertia::render('PestType/Create', [
            //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePestTypeRequest $request)
    {
        $validated = $request->safe()->except(['photo']);
        DB::beginTransaction();
        try {
            $pestType = PestType::create($validated);
                    // Add photo
            if ($request->photo) {
                $pestType->addMedia($request->photo)
                    ->toMediaCollection('pest_type_photos');
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
    public function show(PestType $pestType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PestType $pestType)
    {
        return Inertia::render('PestType/Edit', [
            'model' => $pestType
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePestTypeRequest $request, PestType $pestType)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $pestType->update($validated);

            // Remove photo
            if ($request->remove_photo) {
            $media = $pestType->getFirstMedia('pest_type_photos');
            if ($media) {
                $media->delete();
            }
            }

            // Add photo
            if ($request->photo) {
                $pestType->addMedia($request->photo)
                    ->toMediaCollection('pest_type_photos');
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
                PestType::destroy($request->id_array);
                DB::commit();
                return back();
            } catch (Throwable $e) {
                DB::rollBack();
                return $e;
            }
        }
    }
}
