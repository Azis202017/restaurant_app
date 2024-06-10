<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResepController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Mengambil parameter query untuk filtering dan sorting
        $query = Resep::query();

        // Filtering berdasarkan nama (contoh)
        if ($request->has('judul_resep')) {
            $query->where('judul_resep', 'like', '%' . $request->input('judul_resep') . '%');
        }
        if ($request->has('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }

        // Exclude recipes created by the authenticated user
        $query->where('user_id', '!=', $userId);

        $resep = $query->paginate(50);

        $resep->getCollection()->transform(function ($resep) {
            $resep->foto_url = asset('resep/' . $resep->foto_resep);
            return $resep;
        });

        return response()->json($resep);
    }




    public function create(Request $request)
    {
        if ($request->file('foto')) {
            $uploadedFile = $request->file('foto');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(public_path('tips'), $imageName);
        } else {
            // No custom photo provided, use the default photo
            $imageName = 'default.png';
        }
        $request->validate([
            'judul_resep' => 'required',
        ]);

        $resep = Resep::create([
            'judul_resep' => $request->judul_resep,
            'lama_memasak' => $request->lama_memasak,
            'cara_memasak' => $request->cara_memasak,
            'foto_resep' => $imageName,
            'langkah-langkah' => $request->langkah_langkah,
            'status' => 'diajukan',
            'user_id' => Auth::user()->id,

        ]);


        return response()->json(['data' => $resep], 201);
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'judul_resep' => 'required|string|max:255',
            'lama_memasak' => 'required|string|max:255',
            'cara_memasak' => 'required|string',
            'status' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cari resep berdasarkan ID
        $resep = Resep::findOrFail($id);

        // Cek apakah foto baru diupload
        if ($request->file('foto')) {
            // Hapus foto lama jika ada
            if ($resep->foto_resep && $resep->foto_resep !== 'default.png') {
                $oldImagePath = public_path('resep') . '/' . $resep->foto_resep;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Simpan foto baru
            $uploadedFile = $request->file('foto');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(public_path('resep'), $imageName);
        } else {
            // Gunakan foto lama jika tidak ada foto baru diupload
            $imageName = $resep->foto_resep;
        }

        // Update data resep
        $resep->update([
            'judul_resep' => $request->judul_resep,
            'foto_resep' => $imageName,
            'lama_memasak' => $request->lama_memasak,
            'cara_memasak' => $request->cara_memasak,
            'status' => $request->status,
        ]);

        return response()->json($resep, 200);
    }


    public function changeStatus(
        Request $request,
        $id
    ) {
        $resep = Resep::find($id);
        
        $resep->status = $request->status;
        $resep->save();
        return response()->json($resep, 200);
    }
    public function findMyResept(Request $request)
    {
        $userId = auth()->id();

        $query = Resep::where('user_id', $userId);

        if ($request->has('status')) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }

        $resep = $query->paginate(50);

        $resep->getCollection()->transform(function ($resep) {
            $resep->foto_url = asset('resep/' . $resep->foto_resep);
            return $resep;
        });

        return response()->json($resep, 200);
    }
}
