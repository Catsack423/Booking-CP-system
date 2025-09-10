<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class Floor1Controller extends Controller
{
    function index(){
        $rooms = Room::where('id', 'like', 'CP91%')->get();
        if ($rooms) {
            $now =date("Y-m-d");
            foreach($rooms as $room){
                //เช็คว่าขึ้นวันใหม่มั้ย
                if ($room['day']<$now || $room['day']==null) {
                    $room->day = $now;
                    $room->status=1;
                    $room->save;
                }else if ($room['day']==$now) {
                    # ถ้าresetวันแล้ว
                    $room->request->where('day', '=', $now)->get();
                }
            }
        }

        return view('pages.floor1',compact('rooms'));
    }
}
