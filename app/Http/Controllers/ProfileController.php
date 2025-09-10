<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit'); // สร้าง view resources/views/profile/edit.blade.php
    }

    public function update(Request $request)
    {
        // logic update ข้อมูล user
    }

    public function destroy(Request $request)
    {
        // logic ลบบัญชี user
    }
}
