<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\Question;
use App\Helper as RSA;
use App\Key;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::with('questions')->get();
        return view('question.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $decryptionData = $rsa->privDecrypt($ecryptionData);
        $subject_id = $request->subject_id;
        $questions = Question::where('subject_id', $subject_id)->orderBy('created_at', 'desc')->get();
        return view('question.create', compact('subject_id', 'questions'));
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
            $key = Key::where('user_id', 1)->first();
            $rsa = new RSA\Encryption($key->private_key, $key->public_key);

            $newQuestion = new Question();
            $newQuestion->subject_id    = $request->subject_id;
            $newQuestion->question      = $rsa->publicEncrypt($request->question);
            $newQuestion->option1       = $rsa->publicEncrypt($request->option1);
            $newQuestion->option2       = $rsa->publicEncrypt($request->option2);
            $newQuestion->option3       = $rsa->publicEncrypt($request->option3);
            $newQuestion->option4       = $rsa->publicEncrypt($request->option4);
            $newQuestion->marks         = $request->marks;
            $newQuestion->save();

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'new' => 'something went wrong'], 400);
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
