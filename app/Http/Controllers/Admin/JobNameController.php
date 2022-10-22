<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\JobName;
use App\Models\CategoryJobTranslation;
use App\Models\CategoryJob;
use Cache;


class JobNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $jobnames = JobName::orderBy('name', 'desc');
        
        $jobnames = $jobnames->paginate(15);
        return view('backend.infobase.jobnames.index', compact('jobnames', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
         $categoriesjobs = CategoryJob::where('parent_id', 0)
            ->with('childrenCategoriesjob')
            ->get();

        return view('backend.infobase.jobnames.create', compact('categoriesjobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobname = new JobName;
        $jobname->name = $request->name;
        $jobname->category_job_id = $request->category_job_id;
        $jobname->icon = $request->icon;
        $jobname->save();
    
        flash(translate('JobName has been inserted successfully'))->success();
        return redirect()->route('jobnames.index');
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
        $jobname = JobName::findOrFail($id);
        
        $category = CategoryJob::findOrFail($jobname->category_job_id);

        $categoriesjobs = CategoryJob::where('parent_id', 0)
            ->with('childrenCategoriesjob')
            ->get();
            
        return view('backend.infobase.jobnames.edit', compact('jobname', 'categoriesjobs', 'category'));
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
        $jobname =JobName::findOrFail($id);
        $jobname->name = $request->name;
        $jobname->category_job_id = $request->category_job_id;
		$jobname->icon = $request->icon;
        $jobname->save();

        flash(translate('DepartmentTyp has been updated successfully'))->success();
        return redirect()->route('jobnames.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$category = JobName::where('id', $id)->first();
        $category->delete();

        flash(translate('JobName has been deleted successfully'))->success();
        return redirect()->route('jobnames.index');
    }

    public function updateFeatured(Request $request)
    {
        $jobname = JobName::findOrFail($request->id);
        $jobname->featured = $request->status;
        $jobname->save();
        Cache::forget('featured_jobname');
        return 1;
    }
}
