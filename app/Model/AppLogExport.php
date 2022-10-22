<?php

namespace App\Model;

use App\Model\AppLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AppLogExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return AppLog::all();
    }

    public function headings(): array
    {
        return [
            'userId',
            'openAppCount',
            'openAppTime',
            'closeAppTime',
            'pageName',
            'pageTime',
            'iconName',
            'catId',
            'productId',
            'productIdSeller',
            'sellerId',
            'shopId',
            'brandId',
            'blogId',
            'cityId',
            'cartProducts',
            'typLog',
            'todaydate',
            'status',
        ];
    }

    /**
    * @var Product $product
    */
    public function map($applog): array
    {
       
        return [
             $applog->userId,
             $applog->openAppCount,
             $applog->openAppTime,
             $applog->closeAppTime,
             $applog->pageName,
             $applog->pageTime,
             $applog->iconName,
             $applog->catId,
             $applog->productId,
             $applog->productIdSeller,
             $applog->sellerId,
             $applog->shopId,
             $applog->brandId,
             $applog->blogId,
             $applog->cityId,
             $applog->cartProducts,
             $applog->typLog,
             $applog->todaydate,
             $applog->status,
        ];
    }
}
