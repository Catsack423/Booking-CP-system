<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Request;

class Floor5Controller extends Controller
{


    function index()
    {
        $rooms = Room::where('id', 'like', 'CP95%')->get();
        if ($rooms) {
            $now = date("Y-m-d");
             foreach ($rooms as $room) {
                //เช็คว่าขึ้นวันใหม่มั้ย
                if ($room->day  < $now || $room->day  == null || $room->day  == "0000-00-00") {
                    $room->day = $now;
                    //flase (0) คือว่าง true (1) คือเต็ม
                    $room->status = false;
                    $room->save();
                } else if ($room->day == $now) {
                    # ถ้าresetวันแล้ว
                    $requests = Request::where('day', '=', $now)->where('room_id',"=",$room->id)->get();
                    if ($requests->isEmpty()) {
                        $room->resetslot();
                        continue;
                    }
                    //loop set ค่าroomด้วยslot
                    $room->checkslot($requests);
                }
                $room->checkstatus();
            }
        }

        return view('pages.floor5', compact('rooms'));
    }
}
