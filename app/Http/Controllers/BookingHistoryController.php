<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingHistoryController extends Controller
{
    public function index()
    {
        // ถ้ายังไม่มีข้อมูลจริง แค่ส่ง view เปล่าไปก่อน
        return view('pages.booking-history');
    }
}
