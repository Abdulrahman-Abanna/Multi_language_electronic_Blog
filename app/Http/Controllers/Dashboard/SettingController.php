<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use \Illuminate\Support\Str;



class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $this->authorize($setting);
        return view('dashboard.settings');
    }
    public function update(Request $request,Setting $setting)
    {
        
        $data=[
            'logo'=>'nullable|image|mimes:png,jpg,gif,svg|max:2048',
            'favicon'=>'nullable|image|mimes:png,jpg,gif,svg|max:2048',
            'facebook'=>'nullable|string',
            'instagram'=>'nullable|string',
            'phone'=>'nullable|numeric',
            'email'=>'nullable|email',
        ];
        foreach (config('app.languages') as $key => $value) {
            $data[$key.'*.title']='nullable|string';
            $data[$key.'*.content']='nullable|string';
            $data[$key.'*.address']='nullable|string';
        }
        $request->validate($data);
        $setting->update($request->except('image','favicon','_token'));
        if ($request->file('logo')) {
            $file=$request->file('logo');
            $filename=Str::uuid().$file->getClientOriginalName();
            $file->move(public_path('images'),$filename);
            $path='images/'.$filename;
            $setting->update(['logo'=>$path]);
        }
        if ($request->file('favicon')) {
            $file=$request->file('favicon');
            $filename=Str::uuid().$file->getClientOriginalName();//str::uuid()---given names different to image
            $file->move(public_path('images'),$filename);
            $path='images/'.$filename;
            $setting->update(['favicon'=>$path]);
        }
        return redirect()->route('dashboard.settings');
        
    }
}
