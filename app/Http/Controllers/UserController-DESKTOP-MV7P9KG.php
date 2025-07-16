<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function registerForm(){
        return view('signup');
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => ['required'],
            'username' => ['required', 'min:4', 'max:15', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['required', 'unique:users,phone_number'],
            'address' => ['required'],
            'gender' => ['required'],
            'password' => ['required','min:8','regex:/[A-Z]/','regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed' ],
            'terms' => ['accepted'],
            'role' => ['prohibited']
        ], [
            'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, and one number.',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        unset($validatedData['role']);

        User::create($validatedData);

        return redirect('/login')->with('registerSuccess', 'Registration Success, Please Login!');
    }

    public function loginForm(){
        return view('signin');
    }

    public function login(Request $request){
        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credential)){
            $request->session()->regenerate();

            if(auth()->user()->role == "admin"){

            } else {
                return redirect('/products')->with('loginSuccess', 'Login successfully!');
            }
        }

        return redirect('/login')
                ->with('loginError', 'The provided username and password do not match our records.')
                ->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

        $user = Auth::user();
        return view('User.edit-profile.edit-profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if($user){
            $rules =[
                'name' => ['required', 'min:5'],
                'address' => ['required'],
                'phone_number' => ['required', 'regex:/^(\+62|62|0)[2-9][0-9]{8,14}$/'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024']
            ];

            if($request->email != $user->email){
                $rules['email'] = ['required', 'email', 'unique:users,email,'];
            } else if ($request->username != $user->username){
                $rules['username'] = ['required', 'min:5', 'unique:users,username'];
            }
            
            $validatedData = $request->validate($rules);
            
            if($request->image){
                if($user->image != 'profile-image/elvinson.jpg'){
                    Storage::delete($user->image);
                }
                $validatedData['image'] = $request->image->store('profile-image');
            }

            $user->update(Arr::except($validatedData, ['role']));
            return redirect('/profile')->with('updateSuccess', 'Profile updated successfully');
        }
        return redirect('/profile')->with('updateError', 'There is no user with this username');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login')->with("logoutSuccess", "Logout Successfully!");
    }
}
