<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {
        $folders = Folder::with('images')->get();
        return view('dashboard', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'parent_id' => 'nullable|exists:folders,id']);
        Folder::create($request->only('name', 'parent_id'));

        return back()->with('success', 'Folder created successfully!');
    }

    public function destroy(Folder $folder)
    {
        $folder->delete();
        return back()->with('success', 'Folder deleted successfully!');
    }
}

