<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/reset-password/'.$this->token.'?email='.$notifiable->email);

        return (new MailMessage)
            ->subject('📩 รีเซ็ตรหัสผ่านสำหรับระบบจองห้อง')
            ->greeting('สวัสดีคุณ '.$notifiable->name)
            ->line('คุณได้รับอีเมลนี้เพราะมีการร้องขอรีเซ็ตรหัสผ่านของบัญชีคุณ')
            ->action('รีเซ็ตรหัสผ่าน', $url)
            ->line('หากคุณไม่ได้ร้องขอ ไม่ต้องทำอะไรเพิ่มเติมครับ 😊');
    }
}
