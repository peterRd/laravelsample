<?php

namespace App\Http\Controllers;

use App\Models\Reading;

class ReadingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function readings($id)
    {
        return Reading::where('instrument_id', $id)->all();
    }

    public function reading($id) {

    }
}
