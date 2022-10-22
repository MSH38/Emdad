<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\SellerReqAdd;
use Brian2694\Toastr\Facades\Toastr;
use App\CPU\ImageManager;
use App\SellerReqAddProduct;

class ProductModelController extends Controller
{

    public function addNew(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $addProduct = new Product();
        $addProduct->id               = uniqid(rand(1000,1000000000));
        $addProduct->sku               = $product->sku;
        $addProduct->added_by          = 'seller';
        $addProduct->user_id           = auth('seller')->id();
        $addProduct->name   =  $product->name;
        $addProduct->slug   =  $product->slug;
        $addProduct->category_ids   =  $product->category_ids;
        $addProduct->brand_id   =  $product->brand_id;
        $addProduct->unit   =  $product->unit;
        $addProduct->unit_numbers   =  $product->unit_numbers;
        $addProduct->min_qty   =  $product->min_qty;
        $addProduct->refundable   =  $product->refundable;
        $addProduct->images   =  $product->images;
        $addProduct->thumbnail   =  $product->thumbnail;
        $addProduct->featured   =  $product->featured;
        $addProduct->flash_deal   =  $product->flash_deal;
        $addProduct->video_provider   =  $product->video_provider;
        $addProduct->video_url   =  $product->video_url;
        $addProduct->product_size   =  $product->product_size;
        $addProduct->colors   =  $product->colors;
        $addProduct->variant_product   =  $product->variant_product;
        $addProduct->attributes   =  $product->attributes;
        $addProduct->choice_options   =  $product->choice_options;
        $addProduct->variation   =  $product->variation;
        $addProduct->published   =  $product->published;
        $addProduct->unit_price   =  $request->unit_price;
        $addProduct->purchase_price   =  $request->purchase_price;
        $addProduct->multi_unit_price   =  $product->multi_unit_price;
        $addProduct->tax   =  $product->tax;
        $addProduct->tax_type   =  $product->tax_type;
        $addProduct->discount   =  $product->discount;
        $addProduct->discount_type   =  $product->discount_type;
        $addProduct->current_stock   =  $product->current_stock;
        $addProduct->details   =  $product->details;
        $addProduct->free_shipping   =  $product->free_shipping;
        $addProduct->attachment   =  $product->attachment;
        $addProduct->created_at   =  now();
        $addProduct->updated_at   =  now();
        $addProduct->status   =  $product->status;
        $addProduct->status_branch   =  $product->status_branch;
        $addProduct->featured_status   =  $product->featured_status;
        $addProduct->meta_title   =  $product->meta_title;
        $addProduct->meta_description   =  $product->meta_description;
        $addProduct->meta_image   =  $product->meta_image;
        $addProduct->request_status   =  $product->request_status;
        $addProduct->denied_note   =  $product->denied_note;
        $addProduct->shipping_cost   =  $product->shipping_cost;
        $addProduct->multiply_qty   =  $product->multiply_qty;
        $addProduct->temp_shipping_cost   =  $product->temp_shipping_cost;
        $addProduct->is_shipping_cost_updated   =  $product->is_shipping_cost_updated;
        $addProduct->save();

        Toastr::success('تم اضافة المنتج بنجاح!');
        return redirect()->route('seller.product.list');
    }


    public function addNewMultiPrice(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $addProduct = new Product();
        $addProduct->id               = uniqid(rand(1000,1000000000));
        $addProduct->sku               = $product->sku;
        $addProduct->added_by          = 'seller';
        $addProduct->user_id           = auth('seller')->id();
        $addProduct->name   =  $product->name;
        $addProduct->slug   =  $product->slug;
        $addProduct->category_ids   =  $product->category_ids;
        $addProduct->brand_id   =  $product->brand_id;
        $addProduct->unit   =  $product->unit;
        $addProduct->unit_numbers   =  $product->unit_numbers;
        $addProduct->min_qty   =  $product->min_qty;
        $addProduct->refundable   =  $product->refundable;
        $addProduct->images   =  $product->images;
        $addProduct->thumbnail   =  $product->thumbnail;
        $addProduct->featured   =  $product->featured;
        $addProduct->flash_deal   =  $product->flash_deal;
        $addProduct->video_provider   =  $product->video_provider;
        $addProduct->video_url   =  $product->video_url;
        $addProduct->product_size   =  $product->product_size;
        $addProduct->colors   =  $product->colors;
        $addProduct->variant_product   =  $product->variant_product;
        $addProduct->attributes   =  $product->attributes;
        $addProduct->choice_options   =  $product->choice_options;
        $addProduct->variation   =  $product->variation;
        $addProduct->published   =  $product->published;
        $addProduct->unit_price   =  $request->unit_price;
        $addProduct->purchase_price   =  $request->purchase_price;
        $addProduct->multi_unit_price   =  json_encode(['from_qty' => $request->from_qty,'to_qty' => $request->to_qty,'unit_price' => $request->unit_price,'purchase_price'=>$request->purchase_price]);
        $addProduct->tax   =  $product->tax;
        $addProduct->tax_type   =  $product->tax_type;
        $addProduct->discount   =  $product->discount;
        $addProduct->discount_type   =  $product->discount_type;
        $addProduct->current_stock   =  $product->current_stock;
        $addProduct->details   =  $product->details;
        $addProduct->free_shipping   =  $product->free_shipping;
        $addProduct->attachment   =  $product->attachment;
        $addProduct->created_at   =  now();
        $addProduct->updated_at   =  now();
        $addProduct->status   =  $product->status;
        $addProduct->status_branch   =  $product->status_branch;
        $addProduct->featured_status   =  $product->featured_status;
        $addProduct->meta_title   =  $product->meta_title;
        $addProduct->meta_description   =  $product->meta_description;
        $addProduct->meta_image   =  $product->meta_image;
        $addProduct->request_status   =  $product->request_status;
        $addProduct->denied_note   =  $product->denied_note;
        $addProduct->shipping_cost   =  $product->shipping_cost;
        $addProduct->multiply_qty   =  $product->multiply_qty;
        $addProduct->temp_shipping_cost   =  $product->temp_shipping_cost;
        $addProduct->is_shipping_cost_updated   =  $product->is_shipping_cost_updated;
        $addProduct->save();

        Toastr::success('تم اضافة المنتج بنجاح!');
        return redirect()->route('seller.product.list');
    }

    public function editMultiPrice(Request $request,$id)
    {
        $product = Product::findOrFail($id);
        $product->update(['multi_unit_price' => json_encode(['from_qty' => $request->from_qty,'to_qty' => $request->to_qty,'unit_price' => $request->unit_price,'purchase_price'=>$request->purchase_price])]);
        Toastr::success('تم التعديل بنجاح!');
        return back();
    }

    public function sendRequestAdd(Request $request)
    {
        $seller_req = new SellerReqAdd();

        $seller_req->seller_id = auth('seller')->id();
        $seller_req->product_id = $request->product_id;
        $seller_req->product_item = $request->product_item;
        $seller_req->qty_in_unit = $request->qty_in_units;
        $seller_req->product_size = $request->product_size;
        $seller_req->product_price = $request->product_price;
        $seller_req->qty_in_stock = $request->qty_in_stock;

        if($request->hasFile('image')){
            $seller_req->product_image = ImageManager::upload('product/thumbnail/', 'png', $request->file('image'));
        }
        $seller_req->save();

        Toastr::success('تم ارسال الطلب بنجاح!');
        return redirect()->route('seller.product.list');

    }

    public function sendRequestProduct(Request $request)
    {
        $seller_req_pro = new SellerReqAddProduct();

        $seller_req_pro->seller_id = auth('seller')->id();
        $seller_req_pro->indastry_name = $request->indastry_name;
        $seller_req_pro->product_name = $request->product_name;
        $seller_req_pro->product_type = $request->product_type;
        $seller_req_pro->product_size = $request->product_size;
        $seller_req_pro->qty_in_unit = $request->qty_in_unit;
        $seller_req_pro->product_price = $request->product_price;
        $seller_req_pro->purchase_price = $request->purchase_price;
        $seller_req_pro->qty_in_stock = $request->qty_in_stock;

        if($request->hasFile('image')){
            $seller_req_pro->product_image = ImageManager::upload('product/thumbnail/', 'png', $request->file('image'));
        }
        $seller_req_pro->save();

        Toastr::success('تم ارسال الطلب بنجاح!');
        return redirect()->route('seller.product.list');
    }

    public function updateProPrice(Request $request,$id)
    {
        Product::findOrFail($id)->update(['unit_price' => $request->unit_price]);

        Toastr::success('تم التعديل بنجاح!');
        return redirect()->back();
    }
}
