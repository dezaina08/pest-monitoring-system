<?php

namespace App\Http\Controllers;

use App\Exports\PestTypeExport;
use Throwable;
use App\Models\Pest;
use Inertia\Inertia;
use App\Models\PestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
        $query = PestType::with('media')

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
        return Inertia::render('PestType/Show', [
            'model' => $pestType
        ]);
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
                Pest::whereIn('pest_type_id', $request->id_array)->delete();

                PestType::destroy($request->id_array);
                DB::commit();
                return back();
            } catch (Throwable $e) {
                DB::rollBack();
                return $e;
            }
        }
    }

    /**
     * Export data
     */
    public function export(Request $request)
    {
        $dateRange = "";
        switch ($request['bar_chart_date_range']) {
            case 1:
                $dateRange = "Today";
                break;
            case 2:
                $dateRange = "Yesterday";
                break;
            case 3:
                $dateRange = "Last 7 Days";
                break;
            case 4:
                $dateRange = "Last 30 Days";
                break;
            case 5:
                $dateRange = "Last 90 Days";
                break;
            case 6:
                $dateRange = "All Records";
                break;
            default:
                $dateRange = "All Records";
                break;
        }
        return Excel::download(new PestTypeExport($request->all()), 'Pest Count - ' . date('Y-m-d') . ' - ' . $dateRange . '.xlsx');
    }
}
