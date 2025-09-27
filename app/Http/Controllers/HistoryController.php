<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Request as BookingRequest;
use Illuminate\Http\Request as HttpRequest;

class HistoryController extends Controller
{
    protected function slotColumns(): array
    {
        $cols = [];
        for ($h = 8; $h <= 19; $h++) {
            $cols[] = "{$h}_" . ($h + 1) . "_slot";
        }
        return $cols;
    }

    /**
     * คืนค่าเป็น array ของช่วงเวลา เช่น ['18.00 - 19.00', '20.00 - 21.00']
     *
     * @param BookingRequest $booking
     * @return array
     */
    protected function extractSlotRanges(BookingRequest $booking): array
    {
        $ranges = [];
        $currentStart = null;
        $currentEnd = null;

        foreach ($this->slotColumns() as $col) {
            // ข้ามถ้า column ไม่มีใน attributes
            if (!array_key_exists($col, $booking->getAttributes())) continue;

            // ถ้า slot ถูกจอง
            if ((int) $booking->{$col} === 1) {
                [$s, $e] = array_map('intval', explode('_', Str::beforeLast($col, '_slot')));

                if ($currentStart === null) {
                    // เริ่ม range ใหม่
                    $currentStart = $s;
                    $currentEnd = $e;
                } elseif ($s === $currentEnd) {
                    // ติดต่อกัน → ขยายช่วง
                    $currentEnd = $e;
                } else {
                    // ไม่ติดต่อ → ปิดช่วงเก่า แล้วเริ่มช่วงใหม่
                    $ranges[] = sprintf('%02d.00 - %02d.00', $currentStart, $currentEnd);
                    $currentStart = $s;
                    $currentEnd = $e;
                }
            } else {
                // ถ้าช่องนี้ไม่ถูกจอง แต่มีช่วงเปิดอยู่ให้ปิดมัน
                if ($currentStart !== null) {
                    $ranges[] = sprintf('%02d.00 - %02d.00', $currentStart, $currentEnd);
                    $currentStart = null;
                    $currentEnd = null;
                }
            }
        }

        // ปิดช่วงสุดท้ายถ้ายังไม่ปิด
        if ($currentStart !== null) {
            $ranges[] = sprintf('%02d.00 - %02d.00', $currentStart, $currentEnd);
        }

        return $ranges;
    }

    public function index()
    {
        $userId = Auth::id();

        $bookings = BookingRequest::where('user_id', $userId)
            ->orderByDesc('day')
            ->orderByDesc('id')
            ->get();

        // app/Http/Controllers/HistoryController.php (เฉพาะส่วน map)
        $rows = $bookings->map(function (BookingRequest $b) {
            $slots = $this->extractSlotRanges($b); // array ของช่วงเวลา

            return [
                'id'         => $b->id,
                'room'       => $b->room_id,
                'slots'      => $slots, // <-- ใหม่: ['18.00 - 19.00', '20.00 - 21.00']
                'day'        => $b->day ? Carbon::parse($b->day)->format('d/m/Y') : '-',
                'day_iso'    => $b->day ? Carbon::parse($b->day)->toDateString() : null,
                'first_name' => $b->first_name,
                'last_name'  => $b->last_name,
                'phone'      => $b->phone,
                'detail'     => $b->detail,
                'created_at' => $b->created_at
                    ? Carbon::parse($b->created_at)->timezone('Asia/Bangkok')->format('d/m/Y H:i')
                    : null,
                'wait' =>$b->wait_status,
                'approve' =>$b->approve_status,
                'reject' => $b->reject_status,
            ];
        });
        return view('pages.HistoryBooking', ['rows' => $rows, 'bookings' => $bookings]);
    }
    public function update(HttpRequest $request, int $id)
    {
        $booking = BookingRequest::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'phone'      => ['nullable', 'string', 'max:20'],
            // เปลี่ยนจาก nullable -> sometimes เพื่อไม่โดนแปลง "" เป็น null
            'detail'     => ['sometimes', 'string', 'max:500'],
        ]);

        // กันทุกเคสให้ไม่เป็น null
        $data = array_merge([
            'detail' => $booking->detail ?? '',   // default เดิมใน DB ถ้าไม่ส่งมา
        ], $data);

        if ($data['detail'] === null) {
            $data['detail'] = '';
        }

        $booking->fill($data)->save();

        return back()->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }
    public function destroy(int $id)
    {
        $booking = BookingRequest::where('user_id', Auth::id())->findOrFail($id);
        $booking->delete();

        return back()->with('success', 'ลบประวัติการจองเรียบร้อยแล้ว');
    }
}
