<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\CategoryDep;
use App\Model\DepartmentTyp;
use App\Model\CategoryDepTranslation;
use App\Utility\CategoryDepUtility;
use Illuminate\Support\Str;
use App\CPU\BackEndHelper;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Coupon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryDepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search =null;
        $categorydep = CategoryDep::orderBy('order_level', 'desc');
        if ($request->has('search')){
            $search = $request->search;
            $categorydep = $categorydep->where('name', 'like', '%'.$search.'%');
        }
        $categorydep = $categorydep->paginate(15);
        return view('admin-views.infobase.categoriedep.index', compact('categorydep', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorydep  = CategoryDep::where('parent_id', 0)
            ->with('childrenCategoriesdep')
            ->get();

        return view('admin-views.infobase.categoriedep.create', compact('categorydep'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categorydep = new CategoryDep;
        $categorydep->name = $request->name;
        $categorydep->order_level = 0;
        if($request->order_level != null) {
            $categorydep->order_level = $request->order_level;
        }
        $categorydep->digital = $request->digital;
        $categorydep->banner = $request->banner;
        $categorydep->brand_logo = $request->brand_logo;
    
        $categorydep->icon = $request->icon;
        $categorydep->meta_title = $request->meta_title;
        $categorydep->meta_description = $request->meta_description;

        if ($request->parent_id != "0") {
            $categorydep->parent_id = $request->parent_id;

            $parent = CategoryDep::find($request->parent_id);
            $categorydep->level = $parent->level + 1 ;
        }

        if ($request->slug != null) {
            $categorydep->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $categorydep->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }
        if ($request->commision_rate != null) {
            $categorydep->commision_rate = $request->commision_rate;
        }

        $categorydep->save();

        $categorydep->attributes()->sync($request->filtering_attributes);

        $category_translation = CategoryDepTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'category_dep_id' => $categorydep->id]);
        $category_translation->name = $request->name;
        $category_translation->category_dep_id = $categorydep->id;
        $category_translation->save();

        flash(translate('CategoryDep has been inserted successfully'))->success();
        return redirect()->route('categoriesdep.index');
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
        $categorydep = CategoryDep::findOrFail($id);
        $categorydeps = CategoryDep::where('parent_id', 0)
            ->with('childrenCategoriesdep')
            ->whereNotIn('id', CategoryDepUtility::children_ids($categorydep->id, true))->where('id', '!=' , $categorydep->id)
            ->orderBy('name','asc')
            ->get();

        return view('admin-views.infobase.categoriedep.edit', compact('categorydeps', 'categorydep'));
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
        $categorydep = CategoryDep::findOrFail($id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $categorydep->name = $request->name;
        }
        if($request->order_level != null) {
            $categorydep->order_level = $request->order_level;
        }
        $categorydep->meta_title = $request->meta_title;
        $categorydep->meta_description = $request->meta_description;
        $categorydep->brand_logo = $request->brand_logo;

        $previous_level = $categorydep->level;

        if ($request->parent_id != "0") {
            $categorydep->parent_id = $request->parent_id;

            $parent = CategoryDep::find($request->parent_id);
            $categorydep->level = $parent->level + 1 ;
        }
        else{
            $categorydep->parent_id = 0;
            $categorydep->level = 0;
        }

        if($categorydep->level > $previous_level){
            CategoryDepUtility::move_level_down($categorydep->id);
        }
        elseif ($categorydep->level < $previous_level) {
            CategoryDepUtility::move_level_up($categorydep->id);
        }

        if ($request->slug != null) {
            $categorydep->slug = strtolower($request->slug);
        }
        else {
            $categorydep->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }


        $categorydep->save();

        $category_translation = CategoryDepTranslation::firstOrNew(['lang' => $request->lang, 'category_dep_id' => $categorydep->id]);
        $category_translation->name = $request->name;
        $category_translation->category_dep_id = $categorydep->id;
        $category_translation->save();

        flash(translate('CategoryDep has been updated successfully'))->success();
        return redirect()->route('categoriesdep.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorydep = CategoryDep::findOrFail($id);
        CategoryDepUtility::delete_category($id);
        flash(translate('CategoryDep has been deleted successfully'))->success();
        return redirect()->route('categoriesdep.index');
    }

    public function updateFeatured(Request $request)
    {
        $categorydep = CategoryDep::findOrFail($request->id);
        $categorydep->featured = $request->status;
        $categorydep->save();
        return 1;
    }
    
    public function updateActive(Request $request)
    {
        $categorydep = CategoryDep::findOrFail($request->id);
        $categorydep->active = $request->status;
        $categorydep->save();
        return 1;
    }
}
