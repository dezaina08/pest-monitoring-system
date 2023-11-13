<?php

namespace App\Exports;

use App\Models\PestType;
use App\Services\DashboardService;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PestTypeExport
    implements WithHeadings, WithMapping, FromQuery
{
    protected $request;

    public function __construct(Array $request)
    {
        // dd($request);
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PestType::all();
    }

    public function query()
    {
        // dd(DashboardService::getBarChartData($this->request));
        return DashboardService::getBarChartData($this->request);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Created At',
            'Updated At',
        ];
    }

    /**
    * @param Invoice $pest_type
    */
    public function map($pest_type): array
    {
        return [
            $pest_type->id,
            $pest_type->name,
            $pest_type->description,
            $pest_type->created_at,
            $pest_type->updated_at,
            $pest_type->pests_count,
        ];
    }
}
