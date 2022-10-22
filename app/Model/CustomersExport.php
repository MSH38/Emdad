<?php

namespace App\Model;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Model\User;

class CustomersExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return User::where(['user_type' => 'customer'])->get();
    }

    public function headings(): array
    {
        return [
            'name',
            'email',
            'email_verified_at',
            'country',
            'state',
            'city',
            'phone',
            'balance',
            'job_tyb',
            'info_req',
         
        ];
    }

    /**
    * @var Customer $customer
    */
    public function map($user): array
    {

        return [
            $user->name,
            $user->email,
            $user->email_verified_at,
            $user->country,
            $user->state,
            $user->city,
            $user->phone,
            $user->balance,
            $user->job_tyb,
            $user->info_req,
        ];
    }
}
