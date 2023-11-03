<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\PestType;
use App\Http\Requests\StorePestTypeRequest;
use App\Http\Requests\UpdatePestTypeRequest;

class PestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pestTypes = PestType::all(); // Fetch all pest types from the database

        // Return the data to the Inertia view, which will be used by your Vue component
        return Inertia::render('PestType/Index', [
            'pestTypes' => $pestTypes,
        ]);
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