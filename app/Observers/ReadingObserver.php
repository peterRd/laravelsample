<?php

namespace App\Observers;

use App\Models\Reading;
use Illuminate\Support\Facades\DB;

class ReadingObserver
{
    /**
     * Handle the Reading "created" event.
     *
     * @param  \App\Models\Reading  $reading
     * @return void
     */
    public function created(Reading $reading)
    {
        $reading->invalid = $this->isRecordValid($reading);
        $reading->save();
    }

    /**
     * Handle the Reading "updated" event.
     *
     * @param  \App\Models\Reading  $reading
     * @return void
     */
    public function updated(Reading $reading)
    {
        if (!$reading->wasChanged('invalid')) {
            $reading->invalid = $this->isRecordValid($reading);
            $reading->save();
        }
    }

    protected function isRecordValid(Reading $reading) {
        $dip = DB::table('readings')
            ->where("created_at", "<", $reading->created_at)
            ->where("instrument_id", $reading->instrument_id)
            ->where("id",'!=', $reading->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->avg('dip');

        $previous = Reading::where("created_at", "<", $reading->created_at)
            ->where("instrument_id", $reading->instrument_id)
            ->where("id",'!=', $reading->id)
            ->orderBy('created_at', 'desc')->first();

        if ($dip && $previous &&
            (abs($reading->dip - $dip) > 3 || abs($reading->azimuth - $previous->azimuth) > 5)) {
            return true;
        }

        return false;
    }
}
