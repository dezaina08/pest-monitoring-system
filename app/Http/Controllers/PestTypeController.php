<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\PestType;
use Illuminate\Http\Request;
use App\Http\Requests\StorePestTypeRequest;
use App\Http\Requests\UpdatePestTypeRequest;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePestTypeRequest $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePestTypeRequest $request, PestType $pestType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PestType $pestType)
    {
        //
    }
}
