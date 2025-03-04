<?php

namespace App\Http\Controllers;

use App\Models\logoIcon;
use Illuminate\Http\Request;

class LogoIconController extends Controller
{
    public function index()
    {
        $logoIcons = logoIcon::all();
        return view('index', compact('logoIcons'));
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'icon_title' => 'required|string|max:255',
            'icon_type' => 'required|string',
            'icon_tag' => 'required|string|max:255',
        ]);

        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/icons'), $filename);
            $data['icon_location'] = 'uploads/icons/' . $filename;
        }

        $icon = logoIcon::create($data);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'icon' => $icon]);
        }
        
        return redirect()->route('logo.index')->with('success', 'Icon added successfully');
    }
    
    public function update(Request $request, $id)
    {
        $icon = logoIcon::findOrFail($id);
        
        $data = $request->validate([
            'icon_title' => 'required|string|max:255',
            'icon_type' => 'required|string',
            'icon_tag' => 'required|string|max:255',
        ]);

        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/icons'), $filename);
            $data['icon_location'] = 'uploads/icons/' . $filename;
        }

        $icon->update($data);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'icon' => $icon]);
        }
        
        return redirect()->route('logo.index')->with('success', 'Icon updated successfully');
    }
    
    public function destroy($id)
    {
        $icon = logoIcon::findOrFail($id);
        $icon->delete();
        
        return response()->json(['success' => true]);
    }
    
    public function getIcon($id)
    {
        $icon = logoIcon::findOrFail($id);
        return response()->json($icon);
    }
}
