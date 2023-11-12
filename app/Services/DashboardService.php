<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class DashboardService
{
    public static function getBarChartData($request) {
        $filteredPests = DB::table('pests')
            ->select('pests.*')
            ->leftJoin('pest_images', 'pests.pest_image_id', '=', 'pest_images.id');

        if ($request['bar_chart_date_range'] == 1) {
            // Today
            $filteredPests->where('pest_images.date_captured', '=', date('Y-m-d'));
        } else if ($request['bar_chart_date_range'] == 2) {
            // Yesterday
            $filteredPests->where('pest_images.date_captured', '=', date('Y-m-d', strtotime('-1 day')));
        } else if ($request['bar_chart_date_range'] == 3) {
            // Last 7 days
            $filteredPests->where('pest_images.date_captured', '>=', date('Y-m-d', strtotime('-7 day')))
                ->where('pest_images.date_captured', '<=', date('Y-m-d'));
        } else if ($request['bar_chart_date_range'] == 4) {
            // Last 30 days
            $filteredPests->where('pest_images.date_captured', '>=', date('Y-m-d', strtotime('-30 day')))
                ->where('pest_images.date_captured', '<=', date('Y-m-d'));
        } else if ($request['bar_chart_date_range'] == 5) {
            // Last 90 days
            $filteredPests->where('pest_images.date_captured', '>=', date('Y-m-d', strtotime('-90 day')))
                ->where('pest_images.date_captured', '<=', date('Y-m-d'));
        }

        $pestTypes = DB::table('pest_types')
            ->select(
                'pest_types.*',
                DB::raw('SUM(filtered_pests.count) as pests_count'),
            )
            ->leftJoinSub($filteredPests, 'filtered_pests', function (JoinClause $join) {
                $join->on('pest_types.id', '=', 'filtered_pests.pest_type_id');
            })
            ->groupBy('pest_types.id')
            ->get();

        return $pestTypes;
    }

    public static function getPestsCount($request) {
        $pestsCount = DB::table('pests')->count();
    
        return $pestsCount;
    }

    public static function getPestTypesCount($request) {
        $pestTypesCount = DB::table('pest_types')->count();
    
        return $pestTypesCount;
    }

    public static function getPestImagesCount($request) {
        $pestImagesCount = DB::table('pest_images')->count();
    
        return $pestImagesCount;
    }
}
