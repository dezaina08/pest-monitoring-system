<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class DashboardService
{
    public static function getBarChartData($request) {
        $filteredPests = DB::table('pests')
            ->select('pests.*')
            ->leftJoin('pest_images', 'pests.pest_image_id', '=', 'pest_images.id')
            // If no bar_chart_date_from is provided, use start of month
            ->where('pest_images.date_captured', '>=', $request->bar_chart_date_from ?? date('Y-m-01'))
            // If no bar_chart_date_to is provided, use end of month
            ->where('pest_images.date_captured', '<=', $request->bar_chart_date_to ?? date('Y-m-t'));

        $pestTypes = DB::table('pest_types')
            ->select(
                'pest_types.*',
                'pesticides.name as pesticide',
                DB::raw('SUM(filtered_pests.count) as pests_count'),
            )
            ->join('pesticides', 'pest_types.pesticide_id', '=', 'pesticides.id')
            // Join first query
            ->leftJoinSub($filteredPests, 'filtered_pests', function (JoinClause $join) {
                $join->on('pest_types.id', '=', 'filtered_pests.pest_type_id');
            })
            ->orderByDesc('pests_count')
            ->groupBy('pest_types.id')
            ->get();

        return $pestTypes;
    }

    public static function getPestsCount($request) {
        $pestsCount = DB::table('pests')->sum('count');

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

    public static function getPesticidesCount($request) {
        $pesticidesCount = DB::table('pesticides')->count();

        return $pesticidesCount;
    }
}
