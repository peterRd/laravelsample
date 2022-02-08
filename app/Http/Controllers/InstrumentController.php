<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    public function get($id) {
        return Instrument::find($id);
    }
    public function instruments() {
        return Instrument::all();
    }
}
