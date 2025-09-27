<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class FlashLoginSuccess
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // ใส่ flash เพื่อให้หน้าแรกหลังล็อกอินอ่านแล้วโชว์ Toast
        session()->flash('success', 'เข้าสู่ระบบสำเร็จ');
    }
}
