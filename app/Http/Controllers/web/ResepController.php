<?php

namespace App\Http\Controllers\web;

use App\Models\Resep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResepController extends Controller
{
    public function index() {
        $reseps = Resep::all();
        return view('admin.resep', compact('reseps'));
    }
    public function updateStatus(Request $request, $id)
{
    $resep = Resep::find($id);
    $resep->status = $request->status;
    $resep->save();
    return redirect()->back()->with('success', "Status berhasil diubah menjadi $request->status");


}

}
