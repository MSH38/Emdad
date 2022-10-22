<?php

namespace App\Http\Controllers\Seller\Auth;

use App\City;
use App\CityPlaces;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use App\Model\DayShop;
use App\Model\Day;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CPU\Helpers;
use App\Model\Category;
use PhpParser\JsonDecoder;

class SellerRegisterController extends Controller
{
    public function create()
    {
        return view('seller-views.auth.register');
    }


    public function phone_verify()
    {
        return view('seller-views.auth.phone-verify');
    }



    public function seller_info_1()
    {
        $cat = City::all();
        return view('seller-views.auth.seller-info-1', compact("cat"));
    }


    public function seller_info_2()
    {
        $cat = City::all();
        return view('seller-views.auth.seller-info-2', compact("cat"));
    }





    public function seller_info_3()
    {

        $all_cats = Category::where("parent_id",0)->with("childes")->get();

        // return $data;
        return view('seller-views.auth.seller-info-3', compact( [ "all_cats" ,  ]));
    }




    public function get_places(Request $request)
    {
        // dd($request);
        $cat = CityPlaces::where(['city_id' => $request->city_id])->get();
        $res = '';
        foreach ($cat as $row) {
            if ($row->id == $request->city_id) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }
}
