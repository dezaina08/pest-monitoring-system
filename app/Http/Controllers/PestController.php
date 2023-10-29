<?php

namespace App\Http\Controllers;

use App\Models\Pest;
use App\Http\Requests\StorePestRequest;
use App\Http\Requests\UpdatePestRequest;

class PestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pest $pest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pest $pest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePestRequest $request, Pest $pest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pest $pest)
    {
        //
    }
}
