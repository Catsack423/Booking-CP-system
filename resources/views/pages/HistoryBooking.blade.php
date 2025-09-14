@extends('layouts.app')

@php
  $dayVal = $date ?? now()->toDateString();
@endphp

@section('content')
<link rel="stylesheet" href="{{ asset('css/history.css') }}">

<div class="wrap">
  <div class="actions">
    <a href="{{ route('profile') }}" class="btn">แก้ไขข้อมูลส่วนตัว</a>
    <a href="{{ route('HistoryBooking') }}" class="btn btn-primary">ดูประวัติการจอง</a>
  </div>

  <div class="card">
    <table>
      <thead>
        <tr>
          <th class="col-room">ห้อง</th>
          <th class="col-start">เริ่ม</th>
          <th class="col-end">ถึง</th>
          <th class="col-date">ห้องที่จอง</th>
          <th class="col-appove">แก้ไข/ลบ</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rows as $r)
          <tr>
            <td data-th="ห้อง">{{ $r['room'] }}</td>
            <td data-th="เริ่ม">{{ $r['start'] ?? '-' }}</td>
            <td data-th="ถึง">{{ $r['end'] ?? '-' }}</td>
            <td data-th="ห้องที่จอง">{{ $r['day'] }}</td>
            <td data-th="แก้ไข/ลบ">
              <button type="button" class="btn-open"
                onclick="openEditModal(this)"
                data-id="{{ $r['id'] }}"
                data-room-id="{{ $r['room'] }}"
                data-room-code="{{ $r['room'] }}"
                data-day="{{ $r['day_iso'] }}"
                data-first-name="{{ $r['first_name'] ?? '' }}"
                data-last-name="{{ $r['last_name'] ?? '' }}"
                data-phone="{{ $r['phone'] ?? '' }}"
                data-detail="{{ $r['detail'] ?? '' }}">
                แก้ไข
              </button>
              {{-- ปุ่มลบ --}}
                <form action="{{ route('booking.destroy', $r['id']) }}" method="POST" onsubmit="return confirm('คุณต้องการลบรายการนี้หรือไม่?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-delete">ลบ</button>
                </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="text-align:center;color:#6b7280;padding:28px 20px ">
              ยังไม่มีประวัติการจอง
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Modal --}}
<div id="editModal" class="modal" aria-hidden="true">
  <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="editTitle">
    <div class="modal__head">
      <div id="editTitle" class="modal__title">แก้ไข</div>
      <button type="button" class="modal__close" aria-label="ปิด" onclick="closeEditModal()">×</button>
    </div>


    <form id="editForm" method="POST" class="modal__body">
      @csrf
      <input type="hidden" id="m_id" name="id">
      <input type="hidden" id="m_room_id" name="room_id">
      <input type="hidden" id="m_day" name="day" value="{{ $dayVal }}">

      <label class="field">
        <span class="field__label">Room</span>
        <input id="m_room_code" class="field__input" disabled>
      </label>

      <div class="grid-2">
        <label class="field">
          <span class="field__label">Name</span>
          <input id="m_first_name" name="first_name" class="field__input" placeholder="Name">
        </label>
        <label class="field">
          <span class="field__label">LastName</span>
          <input id="m_last_name" name="last_name" class="field__input" placeholder="LastName">
        </label>
      </div>

      <label class="field">
        <span class="field__label">Phone</span>
        <input id="m_phone" name="phone" class="field__input" placeholder="Phone" inputmode="numeric" maxlength="10">
      </label>

      <label class="field">
        <span class="field__label">Detail</span>
        <textarea id="m_detail" name="detail" class="field__input field__textarea" placeholder="Detail"></textarea>
      </label>

      <div class="modal__footer">
        <button type="submit" class="btn-primary">บันทึก</button>
      </div>
    </form>
  </div>
</div>

{{-- JS --}}
<script>
  const updateUrlTemplate = "{{ route('booking.update', ['id' => '__ID__']) }}";

  function openEditModal(btn){
    const d = btn.dataset;

    // ตั้ง action ให้ฟอร์ม → /history/booking/{id}
    const form = document.getElementById('editForm');
    form.action = updateUrlTemplate.replace('__ID__', d.id);

    // เติมค่า
    document.getElementById('m_id').value         = d.id || '';
    document.getElementById('m_room_id').value    = d.roomId || '';
    document.getElementById('m_room_code').value  = d.roomCode || '';
    document.getElementById('m_day').value        = d.day || '';
    document.getElementById('m_first_name').value = d.firstName || '';
    document.getElementById('m_last_name').value  = d.lastName || '';
    document.getElementById('m_phone').value      = d.phone || '';
    document.getElementById('m_detail').value     = d.detail || '';

    document.getElementById('editModal').classList.add('show');
  }
  function closeEditModal(){ document.getElementById('editModal').classList.remove('show'); }

  // ปิดเมื่อคลิกพื้นหลัง/กด Esc (ถ้ายังไม่ได้ใส่)
  document.addEventListener('click', e=>{
    const m = document.getElementById('editModal');
    if(e.target === m) closeEditModal();
  });
  document.addEventListener('keydown', e=>{
    if(e.key === 'Escape') closeEditModal();
  });
</script>

@endsection
