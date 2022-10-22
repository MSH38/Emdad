<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Branche;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('seller-views.settings.index');
    }

    public function alerts()
    {
        return view('seller-views.settings.partial.alerts');
    }

    public function operational_details()
    {
        return view('seller-views.settings.partial.operational-details');
    }

    public function workTime()
    {
        $branches = Branche::where('seller_id',auth('seller')->id())->get();
        return view('seller-views.settings.partial.workTime',compact('branches'));
    }


    public function employees()
    {
        return view('seller-views.settings.partial.employees');
    }
}
