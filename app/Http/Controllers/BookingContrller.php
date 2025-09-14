<?php

namespace App\Http\Controllers;

use App\Models\Room;

use App\Models\Request as BookingRequest; // ตาราง request
use Illuminate\Http\Request;              // HTTP request
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class BookingContrller extends Controller
{
    public function index(Request $request, $roomId)
{
    $date = $request->query('date', now()->toDateString());

    $room = Room::findOrFail($roomId);
    $rooms = Room::all();

    return view('pages.Booking', [
        'room' => $room,
        'rooms' => $rooms,
        'date' => $date,   // ส่ง date เข้า view
    ]);
}


    public function show($room, $day = null){
    $rooms = Room::where("id",'=',$room)->get();
        if (!$rooms->isEmpty()) {
           return view('pages.Booking',compact('rooms','day'));

        }
        else{
            redirect()->route("floor1");
        }
    }
    


    public function store(Request $request)
    {
         // mapping เวลา → คอลัมน์ในตาราง
        $slotMap = [
        '08:00-09:00' => '8_9_slot',
        '09:00-10:00' => '9_10_slot',
        '10:00-11:00' => '10_11_slot',
        '11:00-12:00' => '11_12_slot',
        '12:00-13:00' => '12_13_slot',
        '13:00-14:00' => '13_14_slot',
        '14:00-15:00' => '14_15_slot',
        '15:00-16:00' => '15_16_slot',
        '16:00-17:00' => '16_17_slot',
        '17:00-18:00' => '17_18_slot',
        '18:00-19:00' => '18_19_slot',
        ];

        

        $data = $request->validate([
            'room_id'    => ['required', Rule::exists('room', 'id')],   // ตารางชื่อ room, คอลัมน์ id
            'day'        => ['required', 'date'],
            'first_name' => ['required', 'string', 'max:200'],
            'last_name'  => ['required', 'string', 'max:200'],
            'phone'      => ['required', 'regex:/^[0-9]{10}$/'],
            'detail'     => ['nullable', 'string', 'max:1000'],
            'slots'      => ['required', 'array', 'min:1'],
            'slots.*'    => ['string'],
        ], [
            'room_id.exists' => 'ไม่พบห้องที่เลือก',
            'phone.regex'    => 'กรุณากรอกเบอร์โทรให้ครบ 10 หลัก',
            'slots.required' => 'กรุณาเลือกช่วงเวลาอย่างน้อย 1 ช่อง',
            'slots.min'      => 'กรุณาเลือกช่วงเวลาอย่างน้อย 1 ช่อง',
        ]);

        $userId = Auth::id();

       
        $slotColumns = [];
        foreach ($data['slots'] as $val) {
            $slotColumns[] = $slotMap[$val] ?? $val; 
        }

       
        $conflict = BookingRequest::where('room_id', $data['room_id'])
            ->whereDate('day', Carbon::parse($data['day'])->toDateString())
            ->where('reject_status', 0)            // ยังไม่ถูกปฏิเสธ
            ->where(function ($q) use ($slotColumns) {
                foreach ($slotColumns as $col) {
                    $q->orWhere($col, 1);
                }
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors(['slots' => 'ช่วงเวลาที่เลือกถูกจองแล้ว โปรดเลือกช่วงเวลาอื่น']);
        }

       
        $payload = [
            'day'            => $data['day'],
            'room_id'        => $data['room_id'],
            'user_id'        => $userId,
            'first_name'     => $data['first_name'],
            'last_name'      => $data['last_name'],
            'phone'          => $data['phone'],
            'detail'         => $data['detail'] ?? null,
            
            'wait_status'    => 1,
            'approve_status' => 0,
            'reject_status'  => 0,
        ];

        // set คอลัมน์ช่วงเวลาที่เลือกเป็น 1 (คอลัมน์อื่น default 0 อยู่แล้วตามตาราง)
        foreach ($slotColumns as $col) {
            $payload[$col] = 1;
        }

        BookingRequest::create($payload);
        return redirect()
            ->route('booking.show', [$data['room_id'], $data['day']])
            ->with('status', 'ส่งคำขอจองเรียบร้อยแล้ว');
    }

}
