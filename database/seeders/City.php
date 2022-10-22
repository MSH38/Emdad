<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class City extends Seeder
{

    public $data = [
        [
             4000,
             "حدد المحافظة"
        ],
        [
             4077,
             "عدن"
        ],
        [
             4078,
             "أبين"
        ],
        [
             4079,
             "ذمار"
        ],
        [
             4080,
             "حضرموت"
        ],
        [
             4084,
             "إب"
        ],
        [
             4085,
             "مأرب"
        ],
        [
             4086,
             "أمانة العاصمة"
        ],
        [
             4087,
             "صعدة"
        ],
        [
             4088,
             "صنعاء"
        ],
        [
             4089,
             "شبوة"
        ],
        [
             4090,
             "تعز"
        ],
        [
             4091,
             "البيضاء"
        ],
        [
             4092,
             "الحديدة"
        ],
        [
             4093,
             "الجوف"
        ],
        [
             4094,
             "المهرة"
        ],
        [
             4095,
             "المحويت"
        ],
        [
             4125,
             "ريمة"
        ],
        [
             4126,
             "سقطرى"
        ],
        [
             4127,
             "لحج"
        ],
        [
             4128,
             "الضالع"
        ],
        [
             4130,
             "حجة"
        ],
        [
             4131,
             "عمران"
        ]
    ];



    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        foreach ($this->data as $dat) {
            DB::table('cities')->insert([
                'id' => $dat[0],
                'name' => $dat[1],
            ]);
        }




    }
}
