<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'max:100', 'email'],
            'password' => ['required'],
        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->all()], 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user == null || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false, 'error' => [
                    'message' => 'The provided credentials do not match our records.',
                ]
            ]);
        }
        Auth::loginUsingId($user->id);
        return response()->json([
            'status' => true,
            'message' => 'successfully loggedIn.',
            'user' => $user
        ]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces|max:75',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->all()], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        Auth::login($user);
        return response()->json([
            'status' => true,
            'message' => 'registration successful.',
        ]);
    }

    // public function changePassword(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'old_password' => 'required',
    //         'new_password' => 'required|confirmed|min:6',
    //     ]);
    //     if ($validator->passes()) {
    //         if(Hash::check($request->old_password, Auth::user()->password))
    //         {
    //             Auth::user()->update([
    //                 'password' => Hash::make($request->new_password)
    //             ]);
    //             return response()->json(['status'=>true]);
    //         }
    //         else
    //         {
    //             $validator->getMessageBag()->add('password', 'Old Password doesn\'t matched');
    //             return response()->json(['status'=>false,'error'=>$validator->errors()->all()]);
    //         }
    //     }
    //     else
    //     {
    //         return response()->json(['status'=>false,'error'=>$validator->errors()->all()]);
    //     }
    // }

    public function logout(Request $request)
    {
        // Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'status' => true,
            'message' => 'successfully logged out.'
        ]);
    }
}
