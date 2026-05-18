<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?: Setting::create(['currency' => 'PKR']);

        return view('settings.index', compact('setting'));
    }

    public function update(StoreSettingRequest $request)
    {
        $setting = Setting::first() ?: Setting::create(['currency' => 'PKR']);

        $data = $request->validated();

        if ($request->hasFile('invoice_logo')) {
            if ($setting->invoice_logo && Storage::disk('public')->exists($setting->invoice_logo)) {
                Storage::disk('public')->delete($setting->invoice_logo);
            }

            $data['invoice_logo'] = $request->file('invoice_logo')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->route('settings.index')->with('success', 'Settings saved successfully.');
    }
}
