<?php

namespace App\Http\Controllers;

use App\Models\Reading;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function readings(Request $request, $id) {
        return Reading::where('instrument_id', $id)->get();
    }

    public function update(Request $request, $id) {
        $reading = Reading::find($id);
        $reading->depth = $request->get('depth');
        if ($reading->isDirty()) {
            return ['success' => true];
        }
        return ['success' => $reading->save()];
    }
}
