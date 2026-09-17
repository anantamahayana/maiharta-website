<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

/** Email reset kata sandi berbahasa Indonesia yang mengarah ke rute admin. */
class AdminResetPassword extends ResetPassword
{
    protected function buildMailMessage($url): MailMessage
    {
        $minutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        return (new MailMessage)
            ->subject('Reset Kata Sandi — Panel Admin MaiHarta')
            ->greeting('Halo,')
            ->line('Kami menerima permintaan untuk mengubah kata sandi akun admin Anda.')
            ->action('Buat Kata Sandi Baru', $url)
            ->line("Tautan ini berlaku selama {$minutes} menit.")
            ->line('Jika Anda tidak merasa meminta, abaikan email ini — kata sandi tidak akan berubah.')
            ->salutation('Tim MaiHarta');
    }

    protected function resetUrl($notifiable): string
    {
        return route('admin.password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]);
    }
}
