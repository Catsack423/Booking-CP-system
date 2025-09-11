<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;

class Floor4Controller extends Controller
{
    function index(){
        $rooms = Room::where('id', 'like', 'CP94%')->get();
        if ($rooms) {
            $now = date("Y-m-d");
            foreach ($rooms as $room) {
                //เช็คว่าขึ้นวันใหม่มั้ย
                if ($room['day'] < $now || $room['day'] == null || $room['day'] == "0000-00-00") {
                    $room->day = $now;
                    //flase (0) คือว่าง true (1) คือเต็ม
                    $room->status = false;
                    $room->save();
                } else if ($room['day'] == $now) {
                    # ถ้าresetวันแล้ว
                    if (!$room->request) {
                        continue;
                    }
                    $requests = $room->request->where('day', '=', $now)->get();
                    //loop set ค่าroomด้วยslot
                    if ($requests->isEmpty()) {
                        continue; // ใช้ continue ให้ไปยัง roomถัดไป
                    }
                    foreach ($requests as $request) {
                        foreach ($room->slot() as $key => $data) {
                            if ($request[$key] == 1) {
                                $data[$key] = $request[$key];
                            }
                        }
                    }
                    
                    
                }
                //กำหนดให้โดนจองไว้ แล้วค่อยไปแก้ในloop
                $room->status = 1;
                    foreach ($room->slot() as $key => $data) {

                        if ($data[$key] == 0) {
                            $room->status = 0;
                            break;
                        }
                }   
            }
        }

        return view('pages.floor4', compact('rooms'));
    }
}
