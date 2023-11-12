<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Pest;
use Inertia\Inertia;
use App\Models\PestImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePestImageRequest;
use App\Http\Requests\UpdatePestImageRequest;

class PestImageController extends Controller
{
    private $tableName = 'pest_images';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('PestImage/Index', [
            'response' => $this->getData($request),
            'search' => $request->search ?? '',
            'order' => [
                'orderBy' => $request->orderBy ?? 'id',
                'orderType' => $request->orderType ?? 'desc'
            ],
        ]);
    }

    private function getData($request)
    {
        $query = PestImage::with('media')

        ->orderBy($this->tableName . '.' . ($request->orderBy ?? 'id'), $request->orderType ?? 'desc')

        ->when($request->search != '', function ($query) use ($request) {
                return $query->orWhere($this->tableName . '.date_captured', 'like', '%' . $request->search . '%');
        })

        ->paginate($request->perPage ?? 10);

        return $query;
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
        return Inertia::render('PestImage/Show', [
            'model' => $pestImage
        ]);
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
    public function destroy(Request $request)
    {
        if(!empty($request->id_array) && is_array($request->id_array)) {
            DB::beginTransaction();
            try {
                Pest::whereIn('pest_image_id', $request->id_array)->delete();

                PestImage::destroy($request->id_array);
                DB::commit();
                return back();
            } catch (Throwable $e) {
                DB::rollBack();
                return $e;
            }
        }
    }
}
