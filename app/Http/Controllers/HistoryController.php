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

    protected function extractStartEnd(BookingRequest $booking): array
    {
        $firstStart = null;
        $lastEnd = null;

        foreach ($this->slotColumns() as $col) {
            if (!array_key_exists($col, $booking->getAttributes())) continue;
            if ((int) $booking->{$col} === 1) {
                [$s, $e] = array_map('intval', explode('_', Str::beforeLast($col, '_slot')));
                $firstStart ??= $s;
                $lastEnd = $e;
            }
        }
        if ($firstStart === null || $lastEnd === null) return [null, null];
        $fmt = fn (int $h) => sprintf('%02d.00', $h);
        return [$fmt($firstStart), $fmt($lastEnd)];
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
    [$start, $end] = $this->extractStartEnd($b);

    return [
        'id'         => $b->id,
        'room'       => $b->room_id,            // ใช้เป็นรหัสห้องด้วย
        'start'      => $start,                 // 18.00
        'end'        => $end,                   // 20.00
        'day'        => $b->day ? Carbon::parse($b->day)->format('d/m/Y') : '-',
        'day_iso'    => $b->day ? Carbon::parse($b->day)->toDateString() : null, // 2023-06-01
        // ใช้เติมฟอร์ม
        'first_name' => $b->first_name,
        'last_name'  => $b->last_name,
        'phone'      => $b->phone,
        'detail'     => $b->detail,
    ];
});
return view('pages.HistoryBooking', ['rows' => $rows, 'bookings' => $bookings]);

    }
    public function update(HttpRequest $request, int $id)
{
    $booking = BookingRequest::where('user_id', Auth::id())->findOrFail($id);

    $data = $request->validate([
        'first_name' => ['nullable','string','max:100'],
        'last_name'  => ['nullable','string','max:100'],
        'phone'      => ['nullable','string','max:20'],
        // เปลี่ยนจาก nullable -> sometimes เพื่อไม่โดนแปลง "" เป็น null
        'detail'     => ['sometimes','string','max:500'],
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

