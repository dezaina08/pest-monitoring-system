<?php

namespace App\Http\Controllers;

use App\Models\Pesticide;
use App\Http\Requests\Pesticide\StorePesticideRequest;
use App\Http\Requests\Pesticide\UpdatePesticideRequest;

class PesticideController extends Controller
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
    public function store(StorePesticideRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesticide $pesticide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesticide $pesticide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePesticideRequest $request, Pesticide $pesticide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesticide $pesticide)
    {
        //
    }
}
