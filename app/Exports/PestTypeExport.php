<?php

namespace App\Exports;

use App\Models\PestType;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PestTypeExport
    implements WithHeadings, WithMapping, FromCollection
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DashboardService::getBarChartData($this->request);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Count',
        ];
    }

    /**
    * @param PestType $pest_type
    */
    public function map($pest_type): array
    {
        return [
            $pest_type->id,
            $pest_type->name,
            $pest_type->pests_count,
        ];
    }
}
