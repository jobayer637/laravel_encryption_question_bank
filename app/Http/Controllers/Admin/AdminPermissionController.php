<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Permission;

class AdminPermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::first();
        return view('admin.permission.index', compact('permission'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);
        try {
            Permission::where('id', 1)->update($data);

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['success' => false], 200);
        }
    }
}
