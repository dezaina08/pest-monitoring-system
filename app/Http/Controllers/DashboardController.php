<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Pest;
use App\Models\PestType;
use App\Models\PestImage;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Dashboard/Dashboard', [
            'pest_types' => DashboardService::getBarChartData($request),
            'pests_count' => DashboardService::getPestsCount($request),
            'pest_types_count' => DashboardService::getPestTypesCount($request),
            'pest_images_count' => DashboardService::getPestImagesCount($request),
            'pesticides_count' => DashboardService::getPesticidesCount($request),

            'pest_type_current_month_count' => DashboardService::getBarChartData([
                'bar_chart_date_from' => date('Y-m-01'),
                'bar_chart_date_to' => date('Y-m-t'),
            ]),

            'bar_chart_date_from' => $request->bar_chart_date_from ?? date('Y-m-01'),
            'bar_chart_date_to' => $request->bar_chart_date_to ?? date('Y-m-t'),
            'monthly_limit' => $request->monthly_limit ?? 10,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
