<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|exists:folders,id',
            'image' => 'required|image|max:2048'
        ]);

        $folder = Folder::find($request->folder_id);
        $path = $request->file('image')->store('images', 'public');

        $folder->images()->create(['path' => $path]);

        return back()->with('success', 'Image uploaded successfully!');
    }
    public function storeImage(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|exists:folders,id',
            'image' => 'required|image|max:2048', // Only allow images up to 2MB
        ]);

        // Get the folder
        $folder = Folder::findOrFail($request->folder_id);

        // Check if the user has already uploaded 10 photos
        $userPhotoCount = $folder->images()->where('user_id', auth()->id())->count();

        if ($userPhotoCount >= 10) {
            return redirect()->back()->with('error', 'You can only upload up to 10 photos.');
        }

        // Store the uploaded image
        $path = $request->file('image')->store('images/' . $folder->id, 'public');

        // Save the image info to the database
        $folder->images()->create([
            'path' => $path,
            'user_id' => auth()->id(), // Associate the photo with the logged-in user
        ]);

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }
    public function download(Image $image)
    {
        // Get the image file from storage
        $filePath = 'public/' . $image->path;

        if (Storage::exists($filePath)) {
            // Provide a download response
            return Storage::download($filePath, basename($image->path));
        } else {
            // Return an error if the file doesn't exist
            return back()->with('error', 'File not found!');
        }
    }
}
