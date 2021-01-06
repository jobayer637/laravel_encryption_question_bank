<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\Subject;
use Illuminate\Support\Str;

class AdminSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::get();
        $subjects = Subject::with('department')->get();
        return view('admin.subject.index', compact('subjects', 'departments'));
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
        try {
            $newSubject = new Subject();
            $newSubject->department_id = $request->department;
            $newSubject->name = $request->subject;
            $newSubject->slug = Str::slug($request->subject, '-');
            $newSubject->code = $request->subject;
            $newSubject->save();

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false], 200);
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
        $subject = Subject::with('department')->find($id);
        $departments = Department::get();
        return view('admin.subject.show', compact('subject', 'departments'));
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
            Subject::where('id', $id)->update($data);

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
            $delete = Subject::where('id', $id)->delete();
            if ($delete) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false], 200);
            }
        } catch (\Exception $ex) {
            return response()->json(['success' => false], 200);
        }
    }
}
