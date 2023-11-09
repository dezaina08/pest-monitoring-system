<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use App\Models\PestImage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePestImageRequest;
use App\Http\Requests\UpdatePestImageRequest;

class PestImageController extends Controller
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
        return Inertia::render('PestImage/Create', [
            //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePestImageRequest $request)
    {
        $validated = $request->validated();
        // dd($validated['photos']);

        DB::beginTransaction();
        try {
            foreach ($validated['photos'] as $photo) {
                $pestImage = PestImage::create([
                    'date_captured' => $validated['date_captured'],
                ]);

                // Add photo
                $pestImage->addMediaFromBase64($photo)
                    ->usingFileName(substr(md5(uniqid(mt_rand(), true)), 0, 8) . '.jpeg')
                    ->toMediaCollection('pest_image_photos');
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
    public function show(PestImage $pestImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PestImage $pestImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePestImageRequest $request, PestImage $pestImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PestImage $pestImage)
    {
        //
    }
}
