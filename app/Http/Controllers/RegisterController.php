<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Key;
use App\Institute;
use PhpParser\Node\Expr\AssignOp\Concat;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManagerStatic as Image;


class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register()
    {
        $institutes = Institute::select('id', 'name')->get();
        return view('custom_auth.register', compact('institutes'));
    }

    public function registerCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'about' => ['min:10', 'string', 'max:500'],
            'phone' => ['required', 'unique:users', 'max:11', 'min:11'],
            'age' => ['required', 'min:1', 'max:3'],
            'institute' => ['required', 'min:1'],
        ]);

        if ($validator->fails()) {
            return redirect('custor-register')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $image = $request->file('image');
            $demoName = Str::random(20) . time();
            $extension = $image->getClientOriginalExtension();
            $name = $demoName . '.' . $extension;

            if (!Storage::disk('public')->exists('images/profile')) {
                Storage::disk('public')->makeDirectory('images/profile');
            }
            $profileImage = Image::make($image)->resize(300, 300)->save('foo');
            Storage::disk('public')->put('images/profile/' . $name, $profileImage);
            $path = 'storage/images/profile/' . $name;

            $data = $request->except(['_token', 'password_confirmation']);


            $newUser = new User();
            $newUser->role_id = 3;
            $newUser->institute_id = $data['institute'];
            $newUser->name = $data['name'];
            $newUser->email = $data['email'];
            $newUser->phone = $data['phone'];
            $newUser->address = $data['address'];
            $newUser->age = $data['age'];
            $newUser->about = $data['about'];
            $newUser->image = $path;
            $newUser->status = false;
            $newUser->password = Hash::make($data['password']);
            $newUser->save();

            $newkey = new Key();
            $newkey->user_id = $newUser->id;
            $newkey->private_key = $data['pr_key'];
            $newkey->public_key = $data['pu_key'];
            $newkey->save();

            return redirect()->route('login');
            // return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            // return response()->json(['success' => false], 200);
            return back();
        }
    }
}
