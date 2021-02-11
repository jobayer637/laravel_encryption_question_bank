<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Subject;
use App\Question;
use App\Helper as RSA;
use App\Key;
use Illuminate\Support\Facades\Auth;
use App\User;

class ModeratorQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'UserSubjectPermission']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $subjects = Subject::with('questions')->get();
        // $subject = Subject::where('id', Auth::user()->subject_id)->with('questions')->first();
        // return view('moderator.question.index', compact('subject'));

        $userId = Auth::user()->id;
        $adminId = User::where('role_id', 1)->select('id')->first();

        $userKeys = Key::where('user_id', $userId)->select(['public_key', 'private_key'])->first();
        $adminKeys = Key::where('user_id', $adminId->id)->select(['public_key', 'private_key'])->first();


        $userRsa = new RSA\Encryption($userKeys->private_key, $userKeys->public_key);
        $adminRsa = new RSA\Encryption($adminKeys->private_key, $adminKeys->public_key);

        $subject =  Subject::where('id', Auth::user()->subject_id)->with('questions')->first();

        foreach ($subject->questions as $k => $question) {
            $question->question = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->question));
            $question->option1  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option1));
            $question->option2  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option2));
            $question->option3  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option3));
            $question->option4  = $userRsa->publicEncrypt($adminRsa->privDecrypt($question->option4));
        }

        return view('moderator.question.index', compact('subject'));
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
        if (Auth::user()->subject_id == $subject_id) {
            $questions = Question::where('subject_id', $subject_id)->orderBy('created_at', 'desc')->get();

            return view('moderator.question.create', compact('subject_id', 'questions'));
        } else {
            return redirect()->back();
        }
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
        try {
            $delete = Question::where('id', $id)->delete();

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false], 200);
        }
    }
}
