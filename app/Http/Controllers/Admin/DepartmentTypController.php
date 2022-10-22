<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DepartmentTyp;
use App\Models\CategoryDepTranslation;
use App\Models\CategoryDep;
use Cache;

class DepartmentTypController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $departmenttyps = DepartmentTyp::orderBy('name', 'desc');
        
        $departmenttyps = $departmenttyps->paginate(15);
        return view('backend.infobase.departmenttyps.index', compact('departmenttyps', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryDep::where('parent_id', 0)
            ->with('childrenCategoriesdep')
            ->get();
            
        $departmenttyps = DepartmentTyp::where('parent_id', 0)
            ->with('childrenCategoriesdep')
            ->get();

        return view('backend.infobase.departmenttyps.create', compact('departmenttyps', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobname = new DepartmentTyp;
        $jobname->name = $request->name;
        $jobname->name = $request->name;
        $jobname->category_dep_id = $request->category_dep_id;
        $jobname->save();
        flash(translate('DepartmentTyp has been inserted successfully'))->success();
        return redirect()->route('departmenttyps.index');
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
        $departmenttyp = DepartmentTyp::findOrFail($id);

        $category = CategoryDep::findOrFail($departmenttyp->category_dep_id);
        
        $categories = CategoryDep::where('parent_id', 0)
            ->with('childrenCategoriesdep')
            ->get();
            
        return view('backend.infobase.departmenttyps.edit', compact('departmenttyp',  'categories', 'category'));
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
        $jobname =DepartmentTyp::findOrFail($id);
        $jobname->name = $request->name;
        $jobname->category_dep_id = $request->category_dep_id;
		$jobname->icon = $request->icon;
        $jobname->save();

        flash(translate('DepartmentTyp has been updated successfully'))->success();
        
        return redirect()->route('departmenttyps.index');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

		$category = DepartmentTyp::where('id', $id)->first();
        $category->delete();

        flash(translate('DepartmentTyp has been deleted successfully'))->success();
        return redirect()->route('departmenttyps.index');
    }

    public function updateFeatured(Request $request)
    {
        $jobname = DepartmentTyp::findOrFail($request->id);
        $jobname->featured = $request->status;
        $jobname->save();
        Cache::forget('featured_departmenttyps');
        return 1;
    }
}
