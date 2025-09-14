<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Request as BookingRequest;
use Illuminate\Http\Request as HttpRequest;

class historyadmin extends Controller
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
            if ((int)$booking->{$col} === 1) {
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
        $bookings = BookingRequest::orderByDesc('day')->orderByDesc('id')->get();

        $rows = $bookings->map(function (BookingRequest $b) {
            [$start, $end] = $this->extractStartEnd($b);

            $status = 'wait';
            if ($b->approve_status) $status = 'approved';
            elseif ($b->reject_status) $status = 'rejected';

            return [
                'id'         => $b->id,
                'room'       => $b->room_id,
                'start'      => $start,
                'end'        => $end,
                'day'        => $b->day ? Carbon::parse($b->day)->format('d/m/Y') : '-',
                'day_iso'    => $b->day ? Carbon::parse($b->day)->toDateString() : null,
                'first_name' => $b->first_name,
                'last_name'  => $b->last_name,
                'phone'      => $b->phone,
                'detail'     => $b->detail,
                'status'     => $status,
            ];
        });

        return view('pages.Historyadmin', compact('rows'));
    }

    public function update(HttpRequest $request, int $id)
    {
        $booking = BookingRequest::findOrFail($id);
        $data = $request->validate([
            'first_name' => ['nullable','string','max:100'],
            'last_name'  => ['nullable','string','max:100'],
            'phone'      => ['nullable','string','max:20'],
            'detail'     => ['sometimes','string','max:500'],
        ]);
        $data = array_merge(['detail' => $booking->detail ?? ''], $data);
        $booking->fill($data)->save();
        return back()->with('success','อัปเดตเรียบร้อย');
    }

    public function approve(int $id)
    {
        $booking = BookingRequest::findOrFail($id);
        $booking->update(['wait_status'=>0,'approve_status'=>1,'reject_status'=>0]);
        return back()->with('success','อนุมัติแล้ว');
    }

    public function reject(int $id)
    {
        $booking = BookingRequest::findOrFail($id);
        $booking->update(['wait_status'=>0,'approve_status'=>0,'reject_status'=>1]);
        return back()->with('success','ปฏิเสธแล้ว');
    }
    
    public function destroy(int $id)
    {
        $booking = BookingRequest::findOrFail($id);
        $booking->delete();
        return back()->with('success', 'ลบการจองเรียบร้อยแล้ว');
    }

}
