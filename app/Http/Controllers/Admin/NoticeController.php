<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::latest()->take(20)->get();
        return view('admin.notice.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notices = Notice::latest()->take(10)->get();
        return view('admin.notice.create', compact('notices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newNotice = new Notice();
        $newNotice->user_id = Auth::user()->id;
        $newNotice->title = $request->title;
        $newNotice->slug = Str::slug($request->title, '-');
        $newNotice->image = 'notice.jpg';
        $newNotice->body = $request->body;
        $newNotice->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        $notices = Notice::latest()->take(10)->get();
        return view('admin.notice.show', compact('notice', 'notices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        $notices = Notice::latest()->take(10)->get();
        return view('admin.notice.edit', compact('notice', 'notices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {

        try {
            $update_notice = [];
            $update_notice['user_id'] = Auth::user()->id;
            $update_notice['title'] = $request->title;
            $update_notice['slug'] = Str::slug($request->title, '-');
            $update_notice['body'] = $request->body;
            Notice::where('id', $notice->id)->update($update_notice);

            return redirect()->route('admin.notice.index');
        } catch (\Exception $ex) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        try {
            $delete = $notice->delete();
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
