<?php

namespace App\Exports;

use App\Models\PricePlan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PricePlanExport implements FromCollection, WithHeadings, WithMapping
{
	protected $id;

	function __construct($id) {
	    $this->id = $id;
	}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return PricePlan::where('domain_id',$this->id)->get();
    }

    /**
    * @var PricePlan priceplan
    */
    public function map($priceplan): array
    {
        return [
            $priceplan->domain->id,
            $priceplan->domain->name,
            $priceplan->urgency->id,
            $priceplan->urgency->name,
            $priceplan->level->id,
            $priceplan->level->name,
            $priceplan->type_of_work->id ?? null,
            $priceplan->type_of_work->name ?? null,
            $priceplan->price,
        ];
    }

    public function headings(): array
    {
        return [
            'Domain ID',
            'Domain Title',
            'Urgency ID',
            'Urgency',
            'Level ID',
            'Level',
            'Type Of Work ID',
            'Type Of Work',
            'Price',
        ];
    }
}
