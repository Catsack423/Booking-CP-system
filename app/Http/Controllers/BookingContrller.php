<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class BookingContrller extends Controller
{
    public function show($room,$date){
        $rooms = Room::where("id",'=',$room)->get();
        if (!$rooms->isEmpty()) {
           return view('pages.Booking',compact('rooms','date'));
        }
        else{
            redirect()->route("floor1");
        }
    }
}
