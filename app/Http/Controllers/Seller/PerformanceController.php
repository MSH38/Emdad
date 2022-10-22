<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\OrderDetail;
use App\Model\Product;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id',auth('seller')->id())->get();

        $product_count = [];
        foreach ($products as $product){
            $count = OrderDetail::where('seller_id',auth('seller')->id())
                    ->where('product_id',$product->id)->count();
            array_push($product_count,['name' => $product->name,'count' => $count]);
        }
        return view('seller-views.performance.index',compact('product_count'));
    }
}
