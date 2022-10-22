<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CategoryJob;
use App\Models\Product;
use App\Models\CategoryJobTranslation;
use App\Utility\CategoryJobUtility;
use Illuminate\Support\Str;
use Cache;

class CategoryJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $categoriesjob = CategoryJob::orderBy('order_level', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $categoriesjob = $categoriesjob->where('name', 'like', '%'.$sort_search.'%');
        }
        $categoriesjob = $categoriesjob->paginate(15);
        return view('backend.infobase.categoriejob.index', compact('categoriesjob', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesjob  = CategoryJob::where('parent_id', 0)
            ->with('childrenCategoriesjob')
            ->get();

        return view('backend.infobase.categoriejob.create', compact('categoriesjob'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryjob = new CategoryJob;
        $categoryjob->name = $request->name;
        $categoryjob->order_level = 0;
        if($request->order_level != null) {
            $categoryjob->order_level = $request->order_level;
        }
        $categoryjob->digital = $request->digital;
        $categoryjob->banner = $request->banner;
        $categoryjob->brand_logo = $request->brand_logo;
    
        $categoryjob->icon = $request->icon;
        $categoryjob->meta_title = $request->meta_title;
        $categoryjob->meta_description = $request->meta_description;

        if ($request->parent_id != "0") {
            $categoryjob->parent_id = $request->parent_id;

            $parent = CategoryJob::find($request->parent_id);
            $categoryjob->level = $parent->level + 1 ;
        }

        if ($request->slug != null) {
            $categoryjob->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $categoryjob->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }
     

        $categoryjob->save();

        $category_translation = CategoryJobTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'category_job_id' => $categoryjob->id]);
        $category_translation->name = $request->name;
        $category_translation->save();

        flash(translate('CategoryJob has been inserted successfully'))->success();
        return redirect()->route('categoriesjob.index');
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
        $lang = $request->lang;
        $categoryjob = CategoryJob::findOrFail($id);
        $categories = CategoryJob::where('parent_id', 0)
            ->with('childrenCategoriesjob')
            ->whereNotIn('id', CategoryJobUtility::children_ids($categoryjob->id, true))->where('id', '!=' , $categoryjob->id)
            ->orderBy('name','asc')
            ->get();

        return view('backend.infobase.categoriejob.edit', compact('categoryjob', 'categories', 'lang'));
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
        $categoryjob = CategoryJob::findOrFail($id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $categoryjob->name = $request->name;
        }
        if($request->order_level != null) {
            $categoryjob->order_level = $request->order_level;
        }
        $categoryjob->digital = $request->digital;
        $categoryjob->banner = $request->banner;
        $categoryjob->icon = $request->icon;
        $categoryjob->meta_title = $request->meta_title;
        $categoryjob->meta_description = $request->meta_description;
        $categoryjob->brand_logo = $request->brand_logo;

        $previous_level = $categoryjob->level;

        if ($request->parent_id != "0") {
            $categoryjob->parent_id = $request->parent_id;

            $parent = CategoryJob::find($request->parent_id);
            $categoryjob->level = $parent->level + 1 ;
        }
        else{
            $categoryjob->parent_id = 0;
            $categoryjob->level = 0;
        }

        if($categoryjob->level > $previous_level){
            CategoryJobUtility::move_level_down($categoryjob->id);
        }
        elseif ($categoryjob->level < $previous_level) {
            CategoryJobUtility::move_level_up($categoryjob->id);
        }

        if ($request->slug != null) {
            $categoryjob->slug = strtolower($request->slug);
        }
        else {
            $categoryjob->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }

        $categoryjob->save();


        $category_translation = CategoryJobTranslation::firstOrNew(['lang' => $request->lang, 'category_job_id' => $categoryjob->id]);
        $category_translation->name = $request->name;
        $category_translation->save();

        flash(translate('CategoryJob has been updated successfully'))->success();
        return redirect()->route('categoriesjob.index');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryjob = CategoryJob::findOrFail($id);

      
        CategoryJobUtility::delete_category($id);

        flash(translate('CategoryJob has been deleted successfully'))->success();
        return redirect()->route('categoriesjob.index');
    }

    public function updateFeatured(Request $request)
    {
        $categoryjob = CategoryJob::findOrFail($request->id);
        $categoryjob->featured = $request->status;
        $categoryjob->save();
        return 1;
    }
    
    public function updateActive(Request $request)
    {
        $categoryjob = CategoryJob::findOrFail($request->id);
        $categoryjob->active = $request->status;
        $categoryjob->save();
        return 1;
    }
}
