<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\VersionSetting;
use Artisan;

class VersionSettingsController extends Controller
{
    public function version_setting(Request $request)
    {
        $versionSettingsInfo = VersionSetting::where('id', 1)->first();
		return view('backend.setup_configurations.version_settings', compact('versionSettingsInfo'));
    }

   public function version_update(Request $request, $id)
    {
        $versionSettingsInfoUpdate = VersionSetting::findOrFail($id);
       
        $versionSettingsInfoUpdate->versionNo = $request->versionNo;
        $versionSettingsInfoUpdate->versionForceUpdate = $request->versionForceUpdate;
        $versionSettingsInfoUpdate->versionTitle = $request->versionTitle;
        $versionSettingsInfoUpdate->versionMessage = $request->versionMessage;
        $versionSettingsInfoUpdate->versionNeedClearData = $request->versionNeedClearData;
        $versionSettingsInfoUpdate->save();

        flash(translate('version Settings Info Update has been updated successfully'))->success();
        return back();

    }
}
