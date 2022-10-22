<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SaleTyp;
use Cache;

class SaleTypController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $saletyps = SaleTyp::orderBy('name', 'desc');
        
        $saletyps = $saletyps->paginate(15);
        return view('backend.infobase.saletyps.index', compact('saletyps', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $saletyps = SaleTyp::where('parent_id', 0)
            ->with('childrenCategories')
            ->get();

        return view('backend.infobase.saletyps.create', compact('saletyps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobname = new SaleTyp;
        $jobname->name = $request->name;
        $jobname->icon = $request->icon;
        $jobname->save();
        flash(translate('SaleTyp has been inserted successfully'))->success();
        return redirect()->route('saletyps.index');
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
    public function edit(Request $request, $id)
    {
        $saletyp = SaleTyp::findOrFail($id);
        $saletyps = SaleTyp::orderBy('name','asc')->get();

        return view('backend.infobase.saletyps.edit', compact('saletyp', 'saletyps'));
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
        $jobname =SaleTyp::findOrFail($id);
        $jobname->name = $request->name;
		$jobname->icon = $request->icon;
        $jobname->save();

        Cache::forget('featured_saletyps');
        flash(translate('SaleTyp has been updated successfully'))->success();
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
        $jobname = SaleTyp::findOrFail($id);
        $jobname->attributes()->detach();

		$category = SaleTyp::where('id', $id)->first();
        $category->delete();

        flash(translate('SaleTyp has been deleted successfully'))->success();
        return redirect()->route('saletyps.index');
    }

    public function updateFeatured(Request $request)
    {
        $jobname = SaleTyp::findOrFail($request->id);
        $jobname->featured = $request->status;
        $jobname->save();
        Cache::forget('featured_saletyps');
        return 1;
    }
}
