<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\MarketTyp;
use Cache;

class MarketTypController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $markettyps = MarketTyp::orderBy('name', 'desc');
        
        $markettyps = $markettyps->paginate(15);
        return view('backend.infobase.markettyps.index', compact('markettyps', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
            
        $markettyps = MarketTyp::where('parent_id', 0)
            ->with('childrenCategories')
            ->get();

        return view('backend.infobase.markettyps.create', compact('markettyps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobname = new MarketTyp;
        $jobname->name = $request->name;
        $jobname->icon = $request->icon;
        $jobname->save();
        flash(translate('MarketTyp has been inserted successfully'))->success();
        return redirect()->route('markettyps.index');
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
        $markettyp = MarketTyp::findOrFail($id);
        $markettyps = MarketTyp::orderBy('name','asc')
            ->get();

        return view('backend.infobase.markettyps.edit', compact('markettyp', 'markettyps'));
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
        $jobname =MarketTyp::findOrFail($id);
        $jobname->name = $request->name;
		$jobname->icon = $request->icon;
        $jobname->save();

        Cache::forget('featured_markettyps');
        flash(translate('MarketTyp has been updated successfully'))->success();
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
        $jobname = MarketTyp::findOrFail($id);
        $jobname->attributes()->detach();

		$category = MarketTyp::where('id', $id)->first();
        $category->delete();

        flash(translate('MarketTyp has been deleted successfully'))->success();
        return redirect()->route('markettyps.index');
    }

    public function updateFeatured(Request $request)
    {
        $jobname = MarketTyp::findOrFail($request->id);
        $jobname->featured = $request->status;
        $jobname->save();
        Cache::forget('featured_markettyps');
        return 1;
    }
}
