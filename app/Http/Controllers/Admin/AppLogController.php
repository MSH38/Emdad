<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductStock;
use App\Models\Category;
use App\Models\FlashDealProduct;
use App\Models\ProductTax;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Color;
use App\Models\User;
use App\Models\State;
use App\Models\AppLog;
use Auth;
use Carbon\Carbon;
use Combinations;
use CoreComponentRepository;
use Illuminate\Support\Str;
use Artisan;
use Cache;
use Illuminate\Support\Facades\Log;

class AppLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_app_log(Request $request)
    {
        $current    = Carbon::now();
        $today      = date("Y-m-d");
        $byesterday = date("Y-m-d", strtotime('-1 days'));
        $montthd    = date("Y-m-d", strtotime('-30 days'));
        $yesterday  = Carbon::yesterday()->format('Y-m-d');
        $todayblade = Carbon::today()->format('Y-m-d');
        
        
        CoreComponentRepository::instantiateShopRepository();
        $monthStart = $current->startOfMonth();

        $type = 'In House';
        $col_name = null;
        $query = null;
        $sort_search = null;
        $dt = Carbon::parse($today);

        $applogs = AppLog::where('status',1);
        $userapplogstoday       = AppLog::where('userId','>', 0)->where('todaydate', $today)->groupBy('userId')->get();
        $userapplogstoday = $userapplogstoday->unique('userId');
        $userapplogstoday = $userapplogstoday->count();
        
        $userapplogsyesterday   = AppLog::where('userId','>', 0)->where('todaydate', $byesterday)->groupBy('userId')->get();
        $userapplogsyesterday = $userapplogsyesterday->unique('userId');
        $userapplogsyesterday = $userapplogsyesterday->count();
        
        $userapplogsmonth       = AppLog::where('userId','>', 0)->where('todaydate', '>' , $montthd)->groupBy('userId')->get();
        $userapplogsmonth = $userapplogsmonth->unique('userId');
        $userapplogsmonth = $userapplogsmonth->count();
        
        $openAppCounttoday       = AppLog::where('openAppCount','=', 1)->where('todaydate', $today)->groupBy('userId')->count();
        $openAppCountyesterday   = AppLog::where('openAppCount','=', 1)->where('todaydate', $yesterday)->groupBy('userId')->count();
        $openAppCountmonth       = AppLog::where('openAppCount','=', 1)->where('todaydate', '>' , $montthd)->groupBy('userId')->count();

        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $applogs = $applogs->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null){
            $applogs = $applogs
                        ->where('userId', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $applogs = $applogs->orderBy('created_at', 'desc')->paginate(50);

        return view('backend.applog.index', compact('applogs','type', 'col_name', 'query', 'sort_search', 'userapplogstoday', 'userapplogsyesterday', 'userapplogsmonth'
        , 'openAppCounttoday', 'openAppCountyesterday', 'openAppCountmonth', 'yesterday', 'monthStart', 'todayblade'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_applogs(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $applogs = AppLog::where('added_by', 'seller')->where('auction_product',0);
        if ($request->has('user_id') && $request->user_id != null) {
            $applogs = $applogs->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null){
            $applogs = $applogs
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $applogs = $applogs->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $applogs = $applogs->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        return view('backend.applog.applogs.index', compact('applogs','type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }

    public function all_applogs(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $applogs = AppLog::orderBy('created_at', 'desc')->where('auction_product',0);
        if ($request->has('user_id') && $request->user_id != null) {
            $applogs = $applogs->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null){
            $applogs = $applogs
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $applogs = $applogs->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $applogs = $applogs->paginate(15);
        $type = 'All';

        return view('backend.applog.applogs.index', compact('applogs','type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CoreComponentRepository::initializeCache();

        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('backend.applog.applogs.create', compact('categories'));
    }

    public function add_more_choice_option(Request $request) {
        $all_attribute_values = AttributeValue::with('attribute')->where('attribute_id', $request->attribute_id)->get();

        $html = '';

        foreach ($all_attribute_values as $row) {
            $html .= '<option value="' . $row->value . '">' . $row->value . '</option>';
        }

        echo json_encode($html);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $applog = new AppLog;
        $applog->name = $request->name;
        $applog->added_by = $request->added_by;
        if(Auth::user()->user_type == 'seller'){
            $applog->user_id = Auth::user()->id;
            if(get_setting('product_approve_by_admin') == 1) {
                $applog->approved = 0;
            }
        }
        else{
            $applog->user_id = User::where('user_type', 'admin')->first()->id;
        }
        $applog->category_id = $request->category_id;
        $applog->brand_id = $request->brand_id;
        $applog->barcode = $request->barcode;

        if (addon_is_activated('refund_request')) {
            if ($request->refundable != null) {
                $applog->refundable = 1;
            }
            else {
                $applog->refundable = 0;
            }
        }
        $applog->photos = $request->photos;
        $applog->thumbnail_img = $request->thumbnail_img;
        $applog->unit = $request->unit;
        $applog->min_qty = $request->min_qty;
        $applog->low_stock_quantity = $request->low_stock_quantity;
        $applog->stock_visibility_state = $request->stock_visibility_state;
        $applog->external_link = $request->external_link;
        $applog->external_link_btn = $request->external_link_btn;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $applog->tags = implode(',', $tags);

        $applog->description = $request->description;
        $applog->video_provider = $request->video_provider;
        $applog->video_link = $request->video_link;
        $applog->unit_price = $request->unit_price;
        $applog->unit_price_max = $request->unit_price_max;
        $applog->discount = $request->discount;
        $applog->discount_type = $request->discount_type;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $applog->discount_start_date = strtotime($date_var[0]);
            $applog->discount_end_date   = strtotime( $date_var[1]);
        }

        $applog->shipping_type = $request->shipping_type;
        $applog->est_shipping_days  = $request->est_shipping_days;

        if (addon_is_activated('club_point')) {
            if($request->earn_point) {
                $applog->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $applog->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $applog->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $applog->shipping_cost = json_encode($request->shipping_cost);
            }
        }
        if ($request->has('is_quantity_multiplied')) {
            $applog->is_quantity_multiplied = 1;
        }

        $applog->meta_title = $request->meta_title;
        $applog->meta_description = $request->meta_description;

        if($request->has('meta_img')){
            $applog->meta_img = $request->meta_img;
        } else {
            $applog->meta_img = $applog->thumbnail_img;
        }

        if($applog->meta_title == null) {
            $applog->meta_title = $applog->name;
        }

        if($applog->meta_description == null) {
            $applog->meta_description = strip_tags($applog->description);
        }

        if($applog->meta_img == null) {
            $applog->meta_img = $applog->thumbnail_img;
        }

        if($request->hasFile('pdf')){
            $applog->pdf = $request->pdf->store('uploads/applogs/pdf');
        }

        $applog->slug = preg_replace('/[^A-Za-z0-9\-s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/', '', str_replace(' ', '-', strtolower($request->name)));
        //$applog->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name)));

        if(AppLog::where('slug', $applog->slug)->count() > 0){
            flash(translate('Another applog exists with same slug. Please change the slug!'))->warning();
            return back();
        }

        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $applog->colors = json_encode($request->colors);
        }
        else {
            $colors = array();
            $applog->colors = json_encode($colors);
        }

        $choice_options = array();

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_'.$no;

                $item['attribute_id'] = $no;

                $data = array();
                // foreach (json_decode($request[$str][0]) as $key => $eachValue) {
                foreach ($request[$str] as $key => $eachValue) {
                    // array_push($data, $eachValue->value);
                    array_push($data, $eachValue);
                }

                $item['values'] = $data;
                array_push($choice_options, $item);
            }
        }

        if (!empty($request->choice_no)) {
            $applog->attributes = json_encode($request->choice_no);
        }
        else {
            $applog->attributes = json_encode(array());
        }

        $applog->choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        $applog->published = 1;
        if($request->button == 'unpublish' || $request->button == 'draft') {
            $applog->published = 0;
        }

        if ($request->has('cash_on_delivery')) {
            $applog->cash_on_delivery = 1;
        }
        if ($request->has('featured')) {
            $applog->featured = 1;
        }
        if ($request->has('todays_deal')) {
            $applog->todays_deal = 1;
        }
        $applog->cash_on_delivery = 0;
        if ($request->cash_on_delivery) {
            $applog->cash_on_delivery = 1;
        }
        //$variations = array();
 
        $applog->attributes_title = serialize($request->attributes_title);
        $applog->attributes_description = serialize($request->attributes_description);
        $city_name = Auth::user()->city;
        $applog->city_id = State::where('name', $city_name)->pluck('id');

        $applog->save();

        //VAT & Tax
        if($request->tax_id) {
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $applog->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }
        //Flash Deal
        if($request->flash_deal_id) {
            $flash_deal_product = new FlashDealProduct;
            $flash_deal_product->flash_deal_id = $request->flash_deal_id;
            $flash_deal_product->product_id = $applog->id;
            $flash_deal_product->save();
        }

        //combinations start
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                foreach ($request[$name] as $key => $eachValue) {
                    array_push($data, $eachValue);
                }
                array_push($options, $data);
            }
        }

        //Generates the combinations of customer choice options
        $combinations = Combinations::makeCombinations($options);
        if(count($combinations[0]) > 0){
            $applog->variant_product = 1;
            foreach ($combinations as $key => $combination){
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                    }
                    else{
                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $product_stock = ProductStock::where('product_id', $applog->id)->where('variant', $str)->first();
                if($product_stock == null){
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $applog->id;
                }

                $product_stock->variant = $str;
                $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
                $product_stock->price_max = $request['price_max_'.str_replace('.', '_', $str)];
                $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
                $product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];
                $product_stock->image = $request['img_'.str_replace('.', '_', $str)];
                $product_stock->save();
            }
        }
        else{
            $product_stock              = new ProductStock;
            $product_stock->product_id  = $applog->id;
            $product_stock->variant     = '';
            $product_stock->price       = $request->unit_price;
            $product_stock->price_max       = $request->unit_price_max;
            $product_stock->sku         = $request->sku;
            $product_stock->qty         = $request->current_stock;
            $product_stock->save();
        }
        //combinations end

	    $applog->save();

        // AppLog Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $applog->id]);
        $product_translation->name = $request->name;
        $product_translation->unit = $request->unit;
        $product_translation->description = $request->description;
        $product_translation->save();

       
        
        flash(translate('AppLog has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        if($request->button == 'publishandnew') {
        
        return redirect()->route('applogs.create');
        
        } else{
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff'){
                return redirect()->route('applogs.admin');
            }
            else{
                if(addon_is_activated('seller_subscription')){
                    $seller = Auth::user()->seller;
                    $seller->remaining_uploads -= 1;
                    $seller->save();
                }
                return redirect()->route('seller.applogs');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function admin_product_edit(Request $request, $id)
     {
        CoreComponentRepository::initializeCache();

        $applog = AppLog::findOrFail($id);
        if($applog->digital == 1) {
            return redirect('digitalapplogs/' . $id . '/edit');
        }

        $lang = $request->lang;
        $tags = json_decode($applog->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('backend.applog.applogs.edit', compact('applog', 'categories', 'tags','lang'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit(Request $request, $id)
    {
        $applog = AppLog::findOrFail($id);
        if($applog->digital == 1) {
            return redirect('digitalapplogs/' . $id . '/edit');
        }
        $lang = $request->lang;
        $tags = json_decode($applog->tags);
        $categories = Category::all();
        return view('backend.applog.applogs.edit', compact('applog', 'categories', 'tags','lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $applog                    = AppLog::findOrFail($id);
        $applog->category_id       = $request->category_id;
        $applog->brand_id          = $request->brand_id;
        $applog->barcode           = $request->barcode;
        $applog->cash_on_delivery = 0;
        $applog->featured = 0;
        $applog->todays_deal = 0;
        $applog->is_quantity_multiplied = 0;
    
        if (addon_is_activated('refund_request')) {
            if ($request->refundable != null) {
                $applog->refundable = 1;
            }
            else {
                $applog->refundable = 0;
            }
        }

        if($request->lang == env("DEFAULT_LANGUAGE")){
            $applog->name          = $request->name;
            $applog->unit          = $request->unit;
            $applog->description   = $request->description;
            $applog->slug          = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->slug)));
        }

        if($request->slug == null){
        $applog->slug = preg_replace('/[^A-Za-z0-9\-s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/', '', str_replace(' ', '-', strtolower($request->name)));
        }

        if(AppLog::where('id', '!=', $applog->id)->where('slug', $applog->slug)->count() > 0){
            flash(translate('Another applog exists with same slug. Please change the slug!'))->warning();
            return back();
        }

        $applog->photos                 = $request->photos;
        $applog->thumbnail_img          = $request->thumbnail_img;
        $applog->min_qty                = $request->min_qty;
        $applog->low_stock_quantity     = $request->low_stock_quantity;
        $applog->stock_visibility_state = $request->stock_visibility_state;
        $applog->external_link = $request->external_link;
        $applog->external_link_btn = $request->external_link_btn;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $applog->tags           = implode(',', $tags);

        $applog->video_provider = $request->video_provider;
        $applog->video_link     = $request->video_link;
        $applog->unit_price     = $request->unit_price;
        $applog->unit_price_max     = $request->unit_price_max;
        $applog->discount       = $request->discount;
        $applog->discount_type     = $request->discount_type;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $applog->discount_start_date = strtotime($date_var[0]);
            $applog->discount_end_date   = strtotime( $date_var[1]);
        }

        $applog->shipping_type  = $request->shipping_type;
        $applog->est_shipping_days  = $request->est_shipping_days;

        $applog->attributes_title = serialize($request->attributes_title);
        $applog->attributes_description = serialize($request->attributes_description);
        
        if (addon_is_activated('club_point')) {
            if($request->earn_point) {
                $applog->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $applog->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $applog->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $applog->shipping_cost = json_encode($request->shipping_cost);
            }
        }

        if ($request->has('is_quantity_multiplied')) {
            $applog->is_quantity_multiplied = 1;
        }
        if ($request->has('cash_on_delivery')) {
            $applog->cash_on_delivery = 1;
        }

        if ($request->has('featured')) {
            $applog->featured = 1;
        }

        if ($request->has('todays_deal')) {
            $applog->todays_deal = 1;
        }

        $applog->meta_title        = $request->meta_title;
        $applog->meta_description  = $request->meta_description;
        $applog->meta_img          = $request->meta_img;

        if($applog->meta_title == null) {
            $applog->meta_title = $applog->name;
        }

        if($applog->meta_description == null) {
            $applog->meta_description = strip_tags($applog->description);
        }

        if($applog->meta_img == null) {
            $applog->meta_img = $applog->thumbnail_img;
        }

        $applog->pdf = $request->pdf;

        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $applog->colors = json_encode($request->colors);
        }
        else {
            $colors = array();
            $applog->colors = json_encode($colors);
        }

        $choice_options = array();

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_'.$no;

                $item['attribute_id'] = $no;

                $data = array();
                foreach ($request[$str] as $key => $eachValue) {
                    array_push($data, $eachValue);
                }

                $item['values'] = $data;
                array_push($choice_options, $item);
            }
        }

        foreach ($applog->stocks as $key => $stock) {
            $stock->delete();
        }

        if (!empty($request->choice_no)) {
            $applog->attributes = json_encode($request->choice_no);
        }
        else {
            $applog->attributes = json_encode(array());
        }

        $applog->choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);


        //combinations start
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        if(count($combinations[0]) > 0){
            $applog->variant_product = 1;
            foreach ($combinations as $key => $combination){
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                    }
                    else{
                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
                            $color_name = Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }

                $product_stock = ProductStock::where('product_id', $applog->id)->where('variant', $str)->first();
                if($product_stock == null){
                    $product_stock = new ProductStock;
                    $product_stock->product_id = $applog->id;
                }
                if(isset($request['price_'.str_replace('.', '_', $str)])) {

                    $product_stock->variant = $str;
                    $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
                    $product_stock->price_max = $request['price_max_'.str_replace('.', '_', $str)];
                    $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
                    $product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];
                    $product_stock->image = $request['img_'.str_replace('.', '_', $str)];

                    $product_stock->save();
                }
            }
        }
        else{
            $product_stock              = new ProductStock;
            $product_stock->product_id  = $applog->id;
            $product_stock->variant     = '';
            $product_stock->price       = $request->unit_price;
            $product_stock->price_max       = $request->unit_price_max;
            $product_stock->sku         = $request->sku;
            $product_stock->qty         = $request->current_stock;
            $product_stock->save();
        }

        $city_id = Auth::user()->city;
        $applog->city_id = State::where('name', $city_id)->pluck('id');
        
        $applog->save();

        //Flash Deal
        if($request->flash_deal_id) {
            if($applog->flash_deal_product){
                $flash_deal_product = FlashDealProduct::findOrFail($applog->flash_deal_product->id);
                if(!$flash_deal_product) {
                    $flash_deal_product = new FlashDealProduct;
                }
            } else {
                $flash_deal_product = new FlashDealProduct;
            }

            $flash_deal_product->flash_deal_id = $request->flash_deal_id;
            $flash_deal_product->product_id = $applog->id;
            $flash_deal_product->discount = $request->flash_discount;
            $flash_deal_product->discount_type = $request->flash_discount_type;
            $flash_deal_product->save();
        }

        //VAT & Tax
        if($request->tax_id) {
            ProductTax::where('product_id', $applog->id)->delete();
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $applog->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }

        // AppLog Translations
        $product_translation                = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $applog->id]);
        $product_translation->name          = $request->name;
        $product_translation->unit          = $request->unit;
        $product_translation->description   = $request->description;
        $product_translation->save();

        flash(translate('AppLog has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applog = AppLog::findOrFail($id);
        foreach ($applog->product_translations as $key => $product_translations) {
            $product_translations->delete();
        }

        foreach ($applog->stocks as $key => $stock) {
            $stock->delete();
        }

        if(AppLog::destroy($id)){
            Cart::where('product_id', $id)->delete();

            flash(translate('AppLog has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_product_delete(Request $request) {
        if($request->id) {
            foreach ($request->id as $product_id) {
                $this->destroy($product_id);
            }
        }

        return 1;
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, $id)
    {
        $applog = AppLog::find($id);

        if(Auth::user()->id == $applog->user_id || Auth::user()->user_type == 'staff'){
            $product_new = $applog->replicate();
            $product_new->slug = $product_new->slug.'-'.Str::random(5);
            $product_new->save();

            foreach ($applog->stocks as $key => $stock) {
                $product_stock              = new ProductStock;
                $product_stock->product_id  = $product_new->id;
                $product_stock->variant     = $stock->variant;
                $product_stock->price       = $stock->price;
                $product_stock->price_max       = $stock->price_max;
                $product_stock->sku         = $stock->sku;
                $product_stock->qty         = $stock->qty;
                $product_stock->save();

            }

            flash(translate('AppLog has been duplicated successfully'))->success();
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff'){
              if($request->type == 'In House')
                return redirect()->route('applogs.admin');
              elseif($request->type == 'Seller')
                return redirect()->route('applogs.seller');
              elseif($request->type == 'All')
                return redirect()->route('applogs.all');
            }
            else{
                if (addon_is_activated('seller_subscription')) {
                    $seller = Auth::user()->seller;
                    $seller->remaining_uploads -= 1;
                    $seller->save();
                }
                return redirect()->route('seller.applogs');
            }
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function get_applogs_by_brand(Request $request)
    {
        $applogs = AppLog::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('applogs'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $applog = AppLog::findOrFail($request->id);
        $applog->todays_deal = $request->status;
        $applog->save();
        Cache::forget('todays_deal_applogs');
        return 1;
    }

    public function updatePublished(Request $request)
    {
        $applog = AppLog::findOrFail($request->id);
        $applog->published = $request->status;

        if($applog->added_by == 'seller' && addon_is_activated('seller_subscription')){
            $seller = $applog->user->seller;
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                return 0;
            }
        }

        $applog->save();
        return 1;
    }

    public function updateProductApproval(Request $request)
    {
        $applog = AppLog::findOrFail($request->id);
        $applog->approved = $request->approved;

        if($applog->added_by == 'seller' && addon_is_activated('seller_subscription')){
            $seller = $applog->user->seller;
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                return 0;
            }
        }

        $applog->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $applog = AppLog::findOrFail($request->id);
        $applog->featured = $request->status;
        if($applog->save()){
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return 1;
        }
        return 0;
    }

    public function updateSellerFeatured(Request $request)
    {
        $applog = AppLog::findOrFail($request->id);
        $applog->seller_featured = $request->status;
        if($applog->save()){
            return 1;
        }
        return 0;
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $unit_price_max = $request->unit_price_max;
        $product_name = $request->name;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                foreach ($request[$name] as $key => $item) {
                    // array_push($data, $item->value);
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.applog.applogs.sku_combinations', compact('combinations', 'unit_price', 'unit_price_max', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $applog = AppLog::findOrFail($request->id);

        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;
        $unit_price_max = $request->unit_price_max;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $data = array();
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                foreach ($request[$name] as $key => $item) {
                    // array_push($data, $item->value);
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = Combinations::makeCombinations($options);
        return view('backend.applog.applogs.sku_combinations_edit', compact('combinations', 'unit_price', 'unit_price_max', 'colors_active', 'product_name', 'applog'));
    }

}
