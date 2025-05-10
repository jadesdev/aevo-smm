<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SystemSetting;
use App\Models\Update;
use Artisan;
use Illuminate\Http\Request;
use Str;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setup.index');
    }
    public function payment()
    {
        return view('admin.setup.payment');
    }
    public function features()
    {
        return view('admin.setup.features');
    }
    public function email()
    {
        return view('admin.setup.email');
    }
    public function custom_styles()
    {
        return view('admin.setup.custom');
    }

    function update(Request $request){
        $input = $request->all();
        if($request->hasFile('favicon')){
            $image = $request->file('favicon');
            $imageName = Str::random(10).'favicon.png';
            $image->move(public_path('uploads'),$imageName);
            $input['favicon'] =$imageName;
        }
        if($request->hasFile('logo')){
            $image = $request->file('logo');
            $imageName = Str::random(10).'logo.png';
            $image->move(public_path('uploads'),$imageName);
            $input['logo'] =$imageName;
        }

        $setting = Setting::first();
        $setting->update($input);

        return redirect()->back()->with('success',__('Settings Updated Successfully.'));
    }
    public function envkeyUpdate(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }
        return back()->withSuccess("Settings updated successfully");

    }

    function systemUpdate(Request $request)
    {
        $setting = SystemSetting::where('name', $request->name)->first();
        if($setting !=null){
            $setting->value = $request->value;
            $setting->save();
        }
        else{
            $setting = new SystemSetting;
            $setting->name = $request->name;
            $setting->value = $request->value;
            $setting->save();
        }

        return '1';
    }

    public function store_settings(Request $request)
    {
        // return $request;
        foreach ($request->types as $key => $type) {
            if($type == 'site_name'){
                $this->overWriteEnvFile('APP_NAME', $request[$type]);
            }
            else {
                $sys_settings = SystemSetting::where('name', $type)->first();

                if($sys_settings!=null){
                    if(gettype($request[$type]) == 'array'){
                        $sys_settings->value = json_encode($request[$type]);
                    }
                    else {
                        $sys_settings->value = $request[$type];
                    }
                    $sys_settings->save();
                }
                else{
                    $sys_settings = new SystemSetting();
                    $sys_settings->name = $type;
                    if(gettype($request[$type]) == 'array'){
                        $sys_settings->value = json_encode($request[$type]);
                    }
                    else {
                        $sys_settings->value = $request[$type];
                    }
                    $sys_settings->save();
                }
            }
        }

        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return redirect()->back()->withSuccess(__('Settings Updated Successfully.'));
    }
    public function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }

    // News section
    public function news_setting()
    {
        $data = Update::orderByDesc('id')->get();
        return view('admin.setup.news', compact('data'));
    }
    function news_setting_create(Request $request)
    {
        // return $request;
        $data = new Update();
        $data->title = $request->title;
        $data->message = $request->message;
        $data->save();

        return redirect()->back()->with('success',__('News update created Successfully.'));
    }
    function news_setting_update(Request $request, $id)
    {
        // return $request;
        $data = Update::findOrFail($id);
        $data->title = $request->title;
        $data->message = $request->message;
        $data->save();

        return redirect()->back()->with('success',__('News updated Successfully.'));
    }
     function news_setting_delete($id)
    {
        // return $request;
        $data = Update::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success',__('News deleted Successfully.'));
    }
}
