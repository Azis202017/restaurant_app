<?php

namespace App\Http\Controllers;

use App\Models\Commentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentarController extends Controller
{
    public function index($communityId)
    {
        $data = Commentar::with(['community', 'user'])
            ->where('community_id', $communityId)
            ->get();

        // Default image URLs
        $defaultCommunityImage = asset('community/default.png');
        $defaultUserImage = asset('image/default.png');

        // Transform community and user foto_url
        $data->transform(function ($comment) use ($defaultCommunityImage, $defaultUserImage) {
            // Add foto_url for community with default fallback
            $comment->community->foto_url = $comment->community->image
                ? asset('community/' . $comment->community->image)
                : $defaultCommunityImage;

            // Add foto_url for user with default fallback
            $comment->user->foto_url = $comment->user->foto
                ? asset('image/' . $comment->user->foto)
                : $defaultUserImage;

            return $comment;
        });

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
