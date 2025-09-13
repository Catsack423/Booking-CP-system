<div id="editModal" class="modal" aria-hidden="true">
  <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="editTitle">
    <div class="modal__head">
      <div id="editTitle" class="modal__title">แก้ไข</div>
      <button type="button" class="modal__close" aria-label="ปิด" onclick="closeEditModal()">×</button>
    </div>

    <form method="POST" action="{{ route('booking.store') }}" class="modal__body">
      @csrf
      {{-- hidden ที่ต้องส่งจริง --}}
      <input type="hidden" name="room_id" value="{{ $roomId ?? '' }}">
      <input type="hidden" name="day"     value="{{ $dayVal ?? now()->toDateString() }}">

      <label class="field">
        <span class="field__label">Room</span>
        <input class="field__input" value="{{ $roomCode ?? '' }}" disabled>
      </label>

      <div class="grid-2">
        <label class="field">
          <span class="field__label">Name</span>
          <input name="first_name" class="field__input" placeholder="Name" value="{{ old('first_name') }}">
        </label>

        <label class="field">
          <span class="field__label">LastName</span>
          <input name="last_name" class="field__input" placeholder="LastName" value="{{ old('last_name') }}">
        </label>
      </div>

      <label class="field">
        <span class="field__label">Phone</span>
        <input name="phone" class="field__input" placeholder="Phone" inputmode="numeric" maxlength="10" value="{{ old('phone') }}">
      </label>

      <label class="field">
        <span class="field__label">Detail</span>
        <textarea name="detail" class="field__input field__textarea" placeholder="Detail">{{ old('detail') }}</textarea>
      </label>

      <div class="modal__footer">
        <button type="submit" class="btn-primary">บันทึก</button>
      </div>
    </form>
  </div>
</div>
