<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Branche;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Model\DeliveryMan;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use function App\CPU\translate;
use App\Model\Day;


class BrancheController extends Controller
{
  public function index()
    {
        $days = Day::all();
        return view('admin-views.branche.index', compact('days'));
    }

    public function list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $branche = Branche::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('branche_name', 'like', "%{$value}%")
                        ->orWhere('branche_address', 'like', "%{$value}%")
                        ->orWhere('manager_phone', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $branche = new Branche();
        }

        $branche = $branche->latest()->paginate(25)->appends($query_param);
        return view('admin-views.branche.list', compact('branche', 'search'));
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $branche = Branche::where(['seller_id' => 0])->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('branche_name', 'like', "%{$value}%")
                    ->orWhere('branche_address', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('manager_phone', 'like', "%{$value}%")
                    ->orWhere('identity_number', 'like', "%{$value}%");
            }
        })->get();
        return response()->json([
            'view' => view('admin-views.branche.partials._table', compact('branche'))->render()
        ]);
    }

    public function preview($id)
    {
        $dm = Branche::with(['reviews'])->where(['id' => $id])->first();
        return view('admin-views.branche.view', compact('dm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branche_name' => 'required',
            'email' => 'required',
            'manager_phone' => 'required',
            'email' => 'required|unique:branche',
            'manager_phone' => 'required|unique:branche',
        ], [
            'branche_name.required' => 'First name is required!'
        ]);

        // $branche = Branche::where(['email' => $request['email'], 'seller_id' => 0])->first();
        // $branche_phone = Branche::where(['phone' => $request['phone'], 'seller_id' => 0])->first();

        // if (isset($branche)) {
        //     $request->validate([
        //         'email' => 'required|unique:branche',
        //     ]);
        // }

        // if (isset($branche_phone)) {
        //     $request->validate([
        //         'phone' => 'required|unique:branche',
        //     ]);
        // }

        $id_img_names = [];
        if (!empty($request->file('identity_image'))) {
            foreach ($request->identity_image as $img) {
                array_push($id_img_names, ImageManager::upload('branche/', 'png', $img));
            }
            $identity_image = json_encode($id_img_names);
        } else {
            $identity_image = json_encode([]);
        }

        $dm = new Branche();
        $dm->seller_id = 0;
        $dm->branche_name = $request->branche_name;
        $dm->branche_name = $request->branche_name;
        $dm->branche_address = $request->branche_address;
        $dm->address = $request->address;
        $dm->latitude = $request->latitude;
        $dm->longitude = $request->longitude;
        $dm->email = $request->email;
        $dm->manager_phone = $request->manager_phone;
        $dm->identity_number = $request->identity_number;
        $dm->identity_type = $request->identity_type;
        $dm->identity_image = $identity_image;
        $dm->branch_photo = ImageManager::upload('branche/', 'png', $request->file('branch_photo'));
        $dm->menager_password = bcrypt($request->menager_password);
        $dm->save();

        Toastr::success('Delivery-man added successfully!');
        return redirect('admin/branches/list');
    }

    public function edit($id)
    {
      $days = Day::all();
      $branche = Branche::find($id);
        return view('admin-views.branche.edit', compact('branche', 'days'));
    }

    public function status(Request $request)
    {
        $branche = Branche::find($request->id);
        $branche->is_active = $request->status;
        $branche->save();
        return response()->json([], 200);
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'branche_name' => 'required',
            'email' => 'required|email|unique:branche,email,'.$id,
            'manager_phone' => 'required|unique:branche,manager_phone,'.$id,
        ], [
            'branche_name.required' => 'First name is required!'
        ]);

        $branche = Branche::where(['id' => $id, 'seller_id' => 0])->first();
        if (isset($branche) && $request['email'] != $branche['email']) {
            $request->validate([
                'email' => 'required|unique:branche',
            ]);
        }

        if (!empty($request->file('identity_image'))) {
            foreach (json_decode($branche['identity_image'], true) as $img) {
                if (Storage::disk('public')->exists('branche/' . $img)) {
                    Storage::disk('public')->delete('branche/' . $img);
                }
            }
            $img_keeper = [];
            foreach ($request->identity_image as $img) {
                array_push($img_keeper, ImageManager::upload('branche/', 'png', $img));
            }
            $identity_image = json_encode($img_keeper);
        } else {
            $identity_image = $branche['identity_image'];
        }
        //$branche->seller_id = $seller->id;
        //$branche->user_id = $seller->id;
        $branche->branche_name = $request->branche_name;
        $branche->branche_address = $request->branche_address;
        $branche->email = $request->email;
        $branche->address = $request->address;
        $branche->latitude = $request->latitude;
        $branche->longitude = $request->longitude;
        $branche->manager_phone = $request->manager_phone;
        $branche->identity_number = $request->identity_number;
        $branche->identity_type = $request->identity_type;
        $branche->identity_image = $identity_image;
        $branche->branch_photo = $request->has('image') ? ImageManager::update('branche/', $branche->branch_photo, 'png', $request->file('branch_photo')) : $branche->branch_photo;
        $branche->menager_password = strlen($request->menager_password) > 1 ? bcrypt($request->menager_password) : $branche['menager_password'];
        $branche->save();

        Toastr::success('Delivery-man updated successfully!');
        return redirect('admin/branches/list');
    }

    public function delete(Request $request)
    {
        $branche = Branche::find($request->id);
        if (Storage::disk('public')->exists('branche/' . $branche['branch_photo'])) {
            Storage::disk('public')->delete('branche/' . $branche['branch_photo']);
        }

        foreach (json_decode($branche['identity_image'], true) as $img) {
            if (Storage::disk('public')->exists('branche/' . $img)) {
                Storage::disk('public')->delete('branche/' . $img);
            }
        }

        $branche->delete();
        Toastr::success(translate('Delivery-man removed!'));
        return back();
    }
}
