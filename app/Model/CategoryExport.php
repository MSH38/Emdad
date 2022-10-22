<?php

namespace App\Model;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Model\Category;

class CategoryExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Category::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'parent_id',
            'level',
            'order_level',
            'banner',
            'icon',
            'brand_logo',
            'balance',
            'featured',
            'top',
            'digital',
            'slug ',
            'active',
        ];
    }

    public function map($category): array
    {
        return [
            $category->name,
            $category->parent_id,
            $category->level,
            $category->order_level,
            $category->banner,
            $category->icon,
            $category->brand_logo,
            $category->balance,
            $category->featured,
            $category->top,
            $category->digital,
            $category->slug,
            $category->active,
        ];
    }
}
