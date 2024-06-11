<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            // Construct the URL for the user's photo.
            // If the user does not have a photo, use 'default.png' as the default photo.
            $fotoUrl = url('/') . '/image/' . ($user->foto ?: 'default.png');

            // Convert the user object to an array
            $userData = $user->toArray();

            // Add the photo URL to the user data array
            $userData['foto_url'] = $fotoUrl;

            // Include the user's reseps in the response and construct the full URL for each reseps's photo
            $reseps = $user->resep()->get()->map(function ($resep) {
                $resepArray = $resep->toArray();
                $resepArray['foto_resep_url'] = url('/') . '/resep/' . $resep->foto_resep;
                return $resepArray;
            });

            $userData['reseps'] = $reseps;

            // Return the user data as a JSON response with a 200 HTTP status code
            return response()->json($userData, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->error([
                    'message' => 'Unauthorized'
                ], 500);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('resep_app')->plainTextToken;
            return response()->json([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => " username dan password salah $error",
            ], 500);
        }
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',],
            ]);


            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            return response()->json([
                'token_type' => 'Bearer',
                'message' => 'Berhasil registrasi',
                'user' => $user
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Ada sesuatu yang salah',
                'error' => $error->getMessage(),
            ], 403);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Token berhasil dihapus']);
    }
}
