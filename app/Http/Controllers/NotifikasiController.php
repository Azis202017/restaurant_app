<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index() {
        $notifikasi = Notifikasi::all();
        $notifikasi = $notifikasi->map(function ($notifikasi) {
            $notifikasi->foto_url = asset('notifikasi/' . $notifikasi->image);
            $notifikasi->image_food_url = asset('notifikasi/' . $notifikasi->image_food);

            return $notifikasi;
        });
        return response()->json([
            "data" => $notifikasi
        ], 200);
    }
    public function create(Request $request) {
        if ($request->file('foto')) {
            $uploadedFile = $request->file('foto');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(public_path('notifikasi'), $imageName);
        } else {
            // No custom photo provided, use the default photo
            $imageName = 'default.png';
        }
        if ($request->file('image_food')) {
            $uploadedFile = $request->file('image_food');
            $imageFood = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(public_path('notifikasi'), $imageFood);
        } else {
            // No custom photo provided, use the default photo
            $imageFood = 'default.png';
        }
        $notifikasi = Notifikasi::create([
            'title' => $request->title,
            'image' => $imageName,
            'description' => $request->description,
            'image_food' => $imageFood,
        ]);
        return response()->json($notifikasi, 201);
    }
}
