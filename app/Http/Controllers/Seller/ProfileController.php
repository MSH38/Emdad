<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\OrderTransaction;
use App\Model\Seller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function App\CPU\translate;

class ProfileController extends Controller
{
    public function view()
    {
        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.view', compact('data'));
    }

    public function edit($id)
    {
        if (auth('seller')->id() != $id) {
            Toastr::warning(translate('you_can_not_change_others_profile'));
            return back();
        }
        $data = Seller::where('id', auth('seller')->id())->first();

        $seller_order = auth('seller')->user()->orders;
        $paid_order = $seller_order->where('payment_status','paid')->count();
        $unpaid_order = $seller_order->where('payment_status','unpaid')->count();

        $pending_order = $seller_order->where('order_status','pending')->count();
        $processing_order = $seller_order->where('order_status','processing')->count();
        $confirmed_order = $seller_order->where('order_status','confirmed')->count();
        $canceled_order = $seller_order->where('order_status','canceled')->count();
        $delivered_order = $seller_order->where('order_status','delivered')->count();

        return view('seller-views.profile.edit',
            compact('data' ,'paid_order','unpaid_order','pending_order','processing_order','confirmed_order','canceled_order','delivered_order'));
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::find(auth('seller')->id());
        $seller->f_name = $request->f_name;
        $seller->l_name = $request->l_name;
        $seller->phone = $request->phone;
        if ($request->image) {
            $seller->image = ImageManager::update('seller/', $seller->image, 'png', $request->file('image'));
        }
        $seller->save();

        Toastr::info('Profile updated successfully!');
        return back();
    }

    public function settings_password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required',
        ]);

        $seller = Seller::find(auth('seller')->id());
        $seller->password = bcrypt($request['password']);
        $seller->save();
        Toastr::success('Seller password updated successfully!');
        return back();
    }

    public function bank_update(Request $request, $id)
    {
        $bank = Seller::find(auth('seller')->id());
        $bank->bank_name = $request->bank_name;
        $bank->branch = $request->branch;
        $bank->holder_name = $request->holder_name;
        $bank->account_no = $request->account_no;
        $bank->save();
        Toastr::success('Bank Info updated');
        return redirect()->route('seller.profile.view');
    }

    public function bank_edit($id)
    {
        if (auth('seller')->id() != $id) {
            Toastr::warning(translate('you_can_not_change_others_info'));
            return back();
        }
        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.bankEdit', compact('data'));
    }

}
