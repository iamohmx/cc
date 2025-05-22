<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * @var string
     */
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
        // FRONTEND_URL ตั้งใน .env เช่น https://app.yourdomain.com
        $url = config('app.frontend_url')
             . '/reset-password?token=' . $this->token
             . '&email=' . urlencode($notifiable->rcc_email);

        return (new MailMessage)
            ->subject('ลิงก์รีเซ็ตรหัสผ่านของคุณ')
            ->greeting('สวัสดี ' . $notifiable->rcc_username)
            ->line('คุณได้รับอีเมลนี้เพราะเราได้รับคำขอรีเซ็ตรหัสผ่านสำหรับบัญชีของคุณ.')
            ->action('รีเซ็ตรหัสผ่าน', $url)
            ->line('ลิงก์นี้จะหมดอายุใน ' . config('auth.passwords.rcc_users.expire') . ' นาที.')
            ->line('ถ้าคุณไม่ได้ขอรีเซ็ตรหัสผ่าน ไม่ต้องทำอะไรเพิ่มเติม.');
    }
}
