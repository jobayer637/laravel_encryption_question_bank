<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\District;
use App\Upazila;
use App\Union;

class ModeratorAjaxController extends Controller
{
    public function districts(Request $request)
    {
        $districts = District::where('division_id', $request->id)->get();
        $data = [];
        foreach ($districts as $key => $district) {
            $data[$district->id] = $district->name;
        }
        return response()->json($data);
    }

    public function upazilas(Request $request)
    {
        $upazilas = Upazila::where('district_id', $request->id)->get();
        $data = [];
        foreach ($upazilas as $key => $upazila) {
            $data[$upazila->id] = $upazila->name;
        }
        return response()->json($data);
    }

    public function unions(Request $request)
    {
        $unions = Union::where('upazila_id', $request->id)->get();
        $data = [];
        foreach ($unions as $key => $union) {
            $data[$union->id] = $union->name;
        }
        return response()->json($data);
    }
}
