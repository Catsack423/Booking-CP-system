<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Request;

class Floor4Controller extends Controller
{
    function index()
    {
        $rooms = Room::where('id', 'like', 'CP94%')->get();
        $floor = 4;
        if ($rooms) {
            $now = date("Y-m-d");
            foreach ($rooms as $room) {
                $now = date("Y-m-d");
                foreach ($rooms as $room) {

                    // อัปเดตวันที่
                    if ($room->day < $now || $room->day == null || $room->day == "0000-00-00") {
                        $room->day = $now;
                        $room->status = false;
                    }

                    $requests = Request::where('day', $now)
                        ->where('room_id', $room->id)
                        ->get();

                    if ($requests->isEmpty()) {
                        $room->resetslot();
                    } else {
                        $room->checkslot($requests);
                    }

                    //เชคว่าห้องว่างมั้ย
                    $room->checkstatus();
                    $room->save();
                }
            }
        }

        return view('pages.floor4', compact('rooms', 'floor'));
    }
}
