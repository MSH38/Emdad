<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\NewReqOrder;
use App\Model\NewReqOrderConv;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewReqOrderController extends Controller
{
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $reqorders = NewReqOrder::orderBy('id','desc')
                                        ->where(function ($q) use ($key) {
                                            foreach ($key as $value) {
                                                $q->Where('subject', 'like', "%{$value}%");
                                            }
                                        });
            $query_param = ['search' => $request['search']];
        }else{
            $reqorders=NewReqOrder::orderBy('id','desc');
        }
        $reqorders = $reqorders->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.new-req-order.view',compact('reqorders','search'));
    }

    public function status(Request $request){
        //return response()->json($request);
        
            $currency = NewReqOrder::find($request->id);
            $currency->status = $request->status;
            $currency->save();


            return response()->json([
                $currency
            ],200);
        
    }
    public function single_new_req_order($id){
        $newReqOrder = NewReqOrder::where('id',$id)->get();
        return view('admin-views.new-req-order.singleView',compact('newReqOrder'));
    }
    public function replay_submit(Request $request){

        $reply=[
            'admin_message'=>$request->replay,
            'admin_id'=>$request->adminId,
            'new_reqorder_id'=>$request->id,
            'created_at' => now(),
            'updated_at' => now()
        ];
        NewReqOrderConv::insert($reply);
        return redirect()->back();
    }

}
