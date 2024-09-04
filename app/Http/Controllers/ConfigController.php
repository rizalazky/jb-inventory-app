<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
Use Alert;

class ConfigController extends Controller
{
    //
    public function view(){
        $data = Setting::first();
        return view('config.view',['data' => $data]);
    }

    public function store(Request $request){
        // Validate the incoming request

        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure the file is an image
        ]);

        // Check if we're updating an existing record or creating a new one


        if ($request->id) {
            $setting = Setting::find($request->id);
        } else {
            $setting = new Setting();
        }

        // Handle the file upload
        if ($request->hasFile('logo')) {
            // Get the file from the request
            $file = $request->file('logo');

            // Generate a unique name for the file before saving it
            $filename = time() . '_' . $file->getClientOriginalName();

            // Save the file in the 'uploads/logos' directory
            $file->storeAs('uploads/logos', $filename, 'public');

            // If updating, delete the old logo if it exists
            if ($setting->logo && \Storage::disk('public')->exists('uploads/logos/' . $setting->logo)) {
                \Storage::disk('public')->delete('uploads/logos/' . $setting->logo);
            }

            // Update the logo field with the new filename
            $setting->logo = $filename;
        }

        // Update or assign other fields
        $setting->name = $request->name;
        $setting->address = $request->address;
        $setting->phone = $request->phone;

        // Save the record
        $setting->save();

        Alert::success('Nice!', 'Data Updated!');
        return redirect()->route('config.index');
    }
}
