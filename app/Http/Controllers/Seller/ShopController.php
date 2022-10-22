<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Shop;
use App\Model\DayShop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Day;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function view()
    {
        $days = Day::all();
        $shop = Shop::where(['seller_id' => auth('seller')->id()])->first();
            if (isset($shop) == false) {
            DB::table('shops')->insert([
                'seller_id' => auth('seller')->id(),
                'name' => auth('seller')->user()->f_name,
                'address' => '',
                'contact' => auth('seller')->user()->phone,
                'image' => 'def.png',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $shop->days()->sync($hours);
            $shop = Shop::where(['seller_id' => auth('seller')->id()])->first();
        }
                $itemw = DayShop::where('shop_id', auth('seller')->id())->get();
        Log::info($itemw);  

        return view('seller-views.shop.shopInfo', compact('shop', 'days'));
    }

    public function edit($id)
    {
        $shop = Shop::where(['seller_id' =>  auth('seller')->id()])->first();
        return view('seller-views.shop.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::find($id);
        $shop->name = $request->name;
        $shop->address = $request->address;
        $shop->contact = $request->contact;
        if ($request->image) {
            $shop->image = ImageManager::update('shop/', $shop->image, 'png', $request->file('image'));
        }
        if ($request->banner) {
            $shop->banner = ImageManager::update('shop/banner/', $shop->banner, 'png', $request->file('banner'));
        }
        $shop->save();
        
 
        Toastr::info('Shop updated successfully!');
        return redirect()->route('seller.shop.view');
    }
    
    public function updateday(Request $request, $id)
    {
        $shop = Shop::find($id);
        $shop->address = $request->address;
        $shop->address_longitude = $request->address_longitude;
        $shop->address_longitude = $request->address_longitude;
        
        $hours = collect($request->input('from_hours'))->mapWithKeys(function($value, $id) use ($request) {
            return $value ? [ 
                    $id => [
                        'from_hours'    => $value, 
                        'from_minutes'  => $request->input('from_minutes.'.$id), 
                        'am_pm'         => $request->input('am_pm.'.$id), 
                        'to_hours'      => $request->input('to_hours.'.$id),
                        'to_minutes'    => $request->input('to_minutes.'.$id),
                        'pm_am'         => $request->input('pm_am.'.$id)
                    ]
                ] 
                : [];
        });
       
        $shop->days()->sync($hours);
        $shop->save();

        Toastr::info('Shop updated successfully!');
        return redirect()->route('seller.shop.view');
    }

}
