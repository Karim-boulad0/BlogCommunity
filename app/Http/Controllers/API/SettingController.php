<?php

namespace App\Http\Controllers\API;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->header());
        $settings = Setting::checkSettings();
        return $settings = SettingResource::make($settings);
        // return $settings->resolve();// btrj3li array
        // return response()->json(['data' => $settings, 'error' => ' '], 200);
    }
}
