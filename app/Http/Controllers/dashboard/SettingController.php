<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SettingTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{

    public function index()
    {
        $setting = Setting::first();
        $this->authorize('view', $setting);
        return view('dashboard.settings');
    }
    // Log Out
    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
    // Update Data For Settings
    public function update(request $request, Setting $settings)
    {
        $data = [
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'facebook' => 'nullable | string',
            'instagram' => 'nullable | string',
            'email' => 'nullable | email',
            'phone' => 'nullable | string',
        ];
        foreach (config('app.languages') as $key => $value) {
            $data[$key . '*.title'] = 'nullable|string';
            $data[$key . '*.content'] = 'nullable|string';
            $data[$key . '*.address'] = 'nullable|string';
        }
        $validateData = $request->validate($data);
        $settings->update($request->except('image', 'favicon', '_token'));
        if (($request->has('logo')) && ($request->has('favicon'))) {
            $logo = $request->file('logo')->getClientOriginalName();
            $pathlogo = $request->file('logo')->storeAs('logo', Str::uuid() . $logo, 'setting');
            $favicon = $request->file('favicon')->getClientOriginalName();
            $pathfavicon = $request->file('favicon')->storeAs('favicon', Str::uuid() . $favicon, 'setting');
            Setting::firstOr()->update([
                'favicon' => $pathfavicon,
                'logo' => $pathlogo
            ]);
        } else {
            echo '<script>alert("sorry")</script>';
        }
        return redirect()->back();
    }
}
