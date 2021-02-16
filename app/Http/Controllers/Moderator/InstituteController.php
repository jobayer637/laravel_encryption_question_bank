<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Division;
use Illuminate\Http\Request;
use App\Institute;
use App\Board;
use App\key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutes = Institute::get();
        return view('moderator.institute.index',  compact('institutes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisions = Division::get();
        $boards = Board::get();
        return view('moderator.institute.create', compact('divisions', 'boards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $new = new Institute();
            $new->user_id = Auth::user()->id;
            $new->board_id = $request->board_id;
            $new->division_id = $request->division_id;
            $new->district_id = $request->district_id;
            $new->upazila_id = $request->upazila_id;
            $new->union_id = $request->union_id;
            $new->name = $request->name;
            $new->slug = Str::slug($request->name, '-');
            $new->eiin = $request->eiin;
            $new->address = $request->address;
            $new->email = $request->email;
            $new->save();

            $newkey = new Key();
            $newkey->user_id = Auth::user()->id;
            $newkey->institute_id = $new->id;
            $newkey->private_key = $request->pr_key;
            $newkey->public_key = $request->pu_key;
            $newkey->save();

            return  redirect()->route('moderator.institutes.index');
        } catch (\Exception $ex) {
            return back();
        }
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
        //
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
