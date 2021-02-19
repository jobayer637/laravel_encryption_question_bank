<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UserAccessMailJob;
use Illuminate\Http\Request;
use App\User;
use App\Subject;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->with(['role', 'institute'])->get();
        return view('admin.user.index', compact('users'));
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
        $subjects = Subject::all();
        $user = User::with(['role', 'institute'])->find($id);
        if ($user->role_id == 1) {
            return back();
        } else {
            return view('admin.user.show', compact('user', 'subjects'));
        }
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
        try {
            $data = $request->except(['_token']);
            $update = User::where('id', $id)->update($data);

            $user = User::find($id);

            // dd($request->status);

            if ($request->status) {
                dispatch(new UserAccessMailJob($user));
            }

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false], 200);
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
        try {
            $delete = User::where('id', $id)->delete();

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false], 200);
        }
    }
}
