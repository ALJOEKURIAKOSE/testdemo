<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, $imageName)
    {
        $username = Auth::user()->name; // Replace this with the actual username of the user
        
        // Check if the like exists in the table
        $likeExists = Like::where('image_name', $imageName)
            ->where('username', $username)
            ->exists();
        
        if (!$likeExists) {
            // Save the like in the database
            $like = new Like();
            $like->image_name = $imageName;
            $like->username = $username;
            $like->save();
        }
        else {
            // Remove the like from the database
            Like::where('image_name', $imageName)
                ->where('username', $username)
                ->delete();
        }
        
        // Get the count of likes for the image
        $likeCount = Like::where('image_name', $imageName)->count();
        
        return back()->with('likeCount', $likeCount);
    }
}
