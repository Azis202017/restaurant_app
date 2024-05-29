<?php

namespace App\Http\Controllers;

use App\Models\Tips;
use Illuminate\Http\Request;

class TipsController extends Controller
{
    public function index() {
        $tips = Tips::all();
        $tips = $tips->map(function ($tips) {
            $tips->foto_url = asset('tips/' . $tips->cover);
            return $tips;
        });
        return response()->json([
            "data" => $tips
        ], 200);
    }
    public function create(Request $request) {
        if ($request->file('foto')) {
            $uploadedFile = $request->file('foto');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(public_path('tips'), $imageName);
        } else {
            // No custom photo provided, use the default photo
            $imageName = 'default.png';
        }
        $request->validate([
            'judul' =>'required',
        ]);

        $tips = Tips::create([
            'judul' => $request->judul,
            'cover' => $imageName,
            'langkah-langkah' => $request->langkah_langkah,
        ]);


        return response()->json($tips, 201);
    }
}
