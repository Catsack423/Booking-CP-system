@extends('layouts.app')

<style>
    :root {
        --blue: #0B76BC;
        --green: #A6F0B5;
        --red: #F3A6A6;
        --yellow: #F8E18B;
        --line: #C9CDD2;
        --card: #F2F4F5;
    }

    .bk-wrap {
        max-width: 1150px;
        margin: 12px auto;
        padding: 0 16px;
        margin-top: 150px;
    }

    .bk-card {
        background: var(--card);
        border: 1px solid #BFC6C9;
        border-radius: 12px;
        padding: 14px
    }

    .bk-grid {
        display: grid;
        grid-template-columns: 170px 1fr 1fr 1fr;
        gap: 10px
    }

    .bk-lbl {
        font-size: 13px;
        margin-bottom: 4px;
        color: #444
    }

    .bk-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #CDD5DA;
        border-radius: 10px;
        background: #fff
    }

    .bk-input[disabled] {
        background: #e9eef2;
        color: #6b7280
    }

    .bk-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 14px 0
    }

    .bk-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 18px;
        border: 1px solid #C9CDD2;
        background: #F6F7F8;
        padding: 6px 14px
    }

    .bk-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px
    }

    /* ตาราง */
    /* ตารางเวลา */
    .bk-table {
        border: 1px solid var(--line);
        border-radius: 8px;
        overflow: hidden;
        margin-top: 16px
    }

    .bk-head {
        display: grid;
        grid-template-columns: repeat(12, 1fr)

    }
    .bk-wrap{max-width:1150px;margin:12px auto;padding:0 16px;margin-top: 150px;}
    .bk-card{background:var(--card);border:1px solid #BFC6C9;border-radius:12px;padding:14px}
    .bk-grid{display:grid;grid-template-columns:170px 1fr 1fr 1fr;gap:10px}
    .bk-lbl{font-size:13px;margin-bottom:4px;color:#444}
    .bk-input{width:100%;padding:10px 12px;border:1px solid #CDD5DA;border-radius:10px;background:#fff}
    .bk-input[disabled]{background:#e9eef2;color:#6b7280}


    .bk-head>div {
        background: #fff;
        border-right: 1px solid var(--line);
        padding: 8px;
        text-align: center;
        font-weight: 600
    }

    /* ตารางเวลา */

    .bk-status {
        display: grid;
        grid-template-columns: repeat(12, 1fr)
    }

    /* คอลลัมตาราง */
    .bk-cell {
        position: relative;
        border-right: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600
    }

    /* คอลลัมตาราง */

    /* ตัวหนังสือในคอลลัมตาราง */
    .bk-chip {
        position: absolute;
        top: 6px;
        left: 10px;
        font-size: 12px
    }

    /* ตัวหนังสือในคอลลัมตาราง */
    /* ตาราง */

    /* ลบ */
    .bk-del {
        position: absolute;
        top: 26px;
        left: 10px;
        background: #C91818;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 12px
    }

    /* ลบ */

    /* ปุ่มเช็ค */
    .bk-check {
        transform: scale(1.2)
    }

    /* ปุ่มเช็ค */

    /* ช่องที่บอกว่าจองแล้ว */
    .bg-booked {
        background: var(--red)
    }

    /* ช่องที่บอกว่าจองแล้ว */

    /* ช่องที่จองได้สีเขียว */
    .bg-free {
        background: var(--green)
    }

    /* ช่องที่จองได้สีเขียว */

    /* ช่องที่รออนุมัติสีเหลือง */
    .bg-pending {
        background: var(--yellow)
    }

    /* ช่องที่รออนุมัติสีเหลือง */

    /* ช่องที่เต็มแล้วสีแดง */
    .bg-full {
        background: #f4a4a4
    }

    /* ช่องที่เต็มแล้วสีแดง */
</style>


@section('title', 'Booking')
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">

@section('content')

    <div class="bk-wrap">
        {{-- ฟอร์มข้อมูล --}}
        <div class="bk-card">
            <div class="bk-grid">
                <div>
                    <div class="bk-lbl">Room</div>
                    <input class="bk-input" value="{{ $rooms->first()->id ?? '' }}" disabled>
                </div>
                <div>
                    <div class="bk-lbl">Name</div>
                    <input class="bk-input" placeholder="Name">
                </div>
                <div>
                    <div class="bk-lbl">Last Name</div>
                    <input class="bk-input" placeholder="Last Name">
                </div>
                <div>
                    <div class="bk-lbl">Phone</div>
                    <input class="bk-input" placeholder="Phone">
                </div>
            </div>
            <div class="mt-3">
                <div class="bk-lbl">Detail</div>
                <input class="bk-input" placeholder="Detail">
            </div>
        </div>

        {{-- ปุ่มเลื่อนวัน --}}
        <div class="bk-topbar">
            <button class="bk-btn">⬅ เมื่อวาน</button>
            <div class="bk-title">📅 วันนี้</div>
            <button class="bk-btn">วันนี้ ➡</button>
        </div>

        {{-- ตารางเวลา --}}
        <div class="bk-table">
            <div class="bk-head">
                <div>08.00</div>
                <div>09.00</div>
                <div>10.00</div>
                <div>11.00</div>
                <div>12.00</div>
                <div>13.00</div>
                <div>14.00</div>
                <div>...</div>
                <div>19.00</div>
            </div>

            <div class="bk-status">
                <div class="bk-cell bg-booked">
                    <span class="bk-chip">จองแล้ว</span>
                    <button class="bk-del">ลบ</button>
                </div>
                <div class="bk-cell bg-free">
                    <span class="bk-chip">ว่าง</span>
                    <input type="checkbox" class="bk-check" checked>
                </div>
                <div class="bk-cell bg-free">
                    <span class="bk-chip">ว่าง</span>
                    <input type="checkbox" class="bk-check">
                </div>
                <div class="bk-cell bg-full">
                    <span class="bk-chip">เต็มแล้ว</span>
                </div>
                <div class="bk-cell bg-free">
                    <span class="bk-chip">ว่าง</span>
                    <input type="checkbox" class="bk-check">
                </div>
                <div class="bk-cell bg-pending">
                    <span class="bk-chip">รออนุมัติ</span>
                </div>
                <div class="bk-cell bg-pending">
                    <span class="bk-chip">รออนุมัติ</span>
                </div>
                <div class="bk-cell bg-pending">
                    <span class="bk-chip">รอใส่</span>
                    <input type="checkbox" class="bk-check">
                </div>
                <div class="bk-cell bg-full">
                    <span class="bk-chip">เต็มแล้ว</span>
                </div>
            </div>
        </div>
    </div>
@endsection

