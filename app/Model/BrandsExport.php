<?php

namespace App\Model;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Model\Brand;

class BrandsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Brand::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'category_id',
            'brand_type',
            'logo',
            'top',
            'slug',
            'meta_title',
        ];
    }

    public function map($brand): array
    {
        return [
            $brand->name,
            $brand->category_id,
            $brand->brand_type,
            $brand->logo,
            $brand->top,
            $brand->slug,
            $brand->meta_title,         
        ];
    }
}
