<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Department;
use App\Subject;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ModeratorSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'UserSubjectPermission']);
    }

    public function index()
    {
        $departments = Department::get();
        $subject = Subject::where('id', Auth::user()->subject_id)->with('department')->first();
        return view('moderator.subject.index', compact('subject', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try {
        //     $newSubject = new Subject();
        //     $newSubject->department_id = $request->department;
        //     $newSubject->name = $request->subject;
        //     $newSubject->slug = Str::slug($request->subject, '-');
        //     $newSubject->code = $request->subject;
        //     $newSubject->save();

        //     return response()->json(['success' => true], 200);
        // } catch (\Exception $ex) {
        //     return response()->json(['success' => false], 200);
        // }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $subject = Subject::with('department')->find($id);
        // $departments = Department::get();
        // return view('moderator.subject.show', compact('subject', 'departments'));

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->back();
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
        // try {
        //     $data = $request->except(['_token']);
        //     Subject::where('id', $id)->update($data);

        //     return response()->json(['success' => true], 200);
        // } catch (\Exception $ex) {
        //     return response()->json(['success' => false], 200);
        // }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // try {
        //     $delete = Subject::where('id', $id)->delete();
        //     if ($delete) {
        //         return response()->json(['success' => true], 200);
        //     } else {
        //         return response()->json(['success' => false], 200);
        //     }
        // } catch (\Exception $ex) {
        //     return response()->json(['success' => false], 200);
        // }

        return redirect()->back();
    }
}
