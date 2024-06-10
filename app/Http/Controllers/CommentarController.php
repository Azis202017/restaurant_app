<?php

namespace App\Http\Controllers;

use App\Models\Commentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentarController extends Controller
{
    public function index($communityId)
    {
        $data = Commentar::with(['community', 'user']) // Add other relationships as needed
            ->where('community_id', $communityId)
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
    public function create(Request $request)
    {
        $data = Commentar::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'community_id' => $request->community_id,
        ]);
        return response()->json(['data' => $data]);
    }
}
