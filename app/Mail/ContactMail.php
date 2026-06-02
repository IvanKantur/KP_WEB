<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(Request $request)
    {
        $this->data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новое сообщение с сайта TechStore',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }
}