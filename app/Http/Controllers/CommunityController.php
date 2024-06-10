<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    
    public function create(Request $request) {
        if ($request->file('foto')) {
            $uploadedFile = $request->file('foto');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(public_path('tips'), $imageName);
        } else {
            // No custom photo provided, use the default photo
            $imageName = 'default.png';
        }

        $community =  Community::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'image ' => $imageName,
        ]);


       return response()->json($community);
    }
}
