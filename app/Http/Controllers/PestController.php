<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Pest;
use Inertia\Inertia;
use App\Models\PestType;
use App\Models\PestImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Pest\StorePestRequest;
use App\Http\Requests\Pest\UpdatePestRequest;

class PestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if ($request['date_captured']) {
        //     $pest_image = PestImage::where('date_captured', $request['date_captured'])
        //                             ->where('id', $request['pest_image_id'])
        //                             ->first();

        //     if (!$pest_image) {
        //         abort(404);
        //     }
        // }

        $rawPestTypes = PestType::with('media')->get();
        $pestImages = PestImage::with('media', 'pests')
                        ->where('date_captured', $request->date_captured ?? date("Y-m-d"))
                        ->get();

        $pestTypes = array_map(function($item) {
            $item['count'] = 0;
            return $item;
        }, $rawPestTypes->toArray());

        return Inertia::render('Pest/Counting', [
            'pest_types' => $pestTypes,
            'pest_images' => $pestImages,
            'date_captured' => $request->date_captured ?? date("Y-m-d"),
            'pest_image_id' => $request->pest_image_id ?? $pestImages[0]['id'] ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePestRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);
        DB::beginTransaction();
        try {

            $pest_image = PestImage::where('date_captured', $validated['date_captured'])
                                    ->where('id', $validated['pest_image_id'])
                                    ->first();

            if (!$pest_image) {
                abort(404);
            }

            $filtered_pest_types = array_filter($validated['pest_types'], function($item) {
                return $item['count'] > 0;
            });

            // Delete all current pests
            Pest::where('pest_image_id', $validated['pest_image_id'])
                ->delete();

            // Create pest items
            foreach ($filtered_pest_types as $item) {
                Pest::create([
                    'pest_image_id' => $validated['pest_image_id'],
                    'pest_type_id' => $item['id'],
                    'count' => $item['count'],
                ]);
            }

            // dd($pest_image->pests);
            // dd($filtered_pest_types);

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
