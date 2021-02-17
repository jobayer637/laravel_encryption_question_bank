<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Subject;
use App\Question;
use App\Helper as RSA;
use App\Key;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthorQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $adminId = User::where('role_id', 1)->select('id')->first();

        $userKeys = Key::where('user_id', $userId)->select(['public_key', 'private_key'])->first();
        $adminKeys = Key::where('user_id', $adminId->id)->select(['public_key', 'private_key'])->first();


        $userRsa = new RSA\Encryption($userKeys->private_key, $userKeys->public_key);
        $adminRsa = new RSA\Encryption($adminKeys->private_key, $adminKeys->public_key);

        $subjects = Subject::with('questions')->get();

        foreach ($subjects as $key => $subject) {
            foreach ($subject->questions as $k => $question) {
                $question->question = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->question));
                $question->option1  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option1));
                $question->option2  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option2));
                $question->option3  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option3));
                $question->option4  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option4));
            }
        }

        return view('author.question.index', compact('subjects'));
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
        $subject = Subject::where('slug', $id)->with('questions')->first();
        return view('author.question.show', compact('subject'));
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
