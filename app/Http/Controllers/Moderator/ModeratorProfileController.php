<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;


class ModeratorProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->with(['role', 'institute'])->first();
        return view('moderator.profile.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $name = Str::slug(Auth::user()->name, '-') . '_' . Str::random(5) . '_' . time();
            $merge_name = $name . '.' . $ext;

            if (!Storage::disk('public')->exists('images/profile')) {
                Storage::disk('public')->makeDirectory('images/profile');
            }

            $profileImage = Image::make($image)->resize(300, 320)->save('foo');
            Storage::disk('public')->put('images/profile/' . $merge_name, $profileImage);
            $path = 'storage/images/profile/' . $merge_name;

            $data['image'] = $path;
        }

        try {
            User::where('id', $id)->update($data);

            return back();
        } catch (\Exception $ex) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
