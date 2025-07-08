<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification
{
    use Queueable;

    protected $customer;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Customer $customer
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Email Verification')
        ->line('Please click the button below to verify your email address.')
        ->action('Verify Email', url('/verify-email/' . $this->customer->id . '/' . sha1($this->customer->email)))  // Include the hash of the email
        ->line('Thank you for using our application!');
}


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // Optionally include data to store in the database
        ];
    }
}
