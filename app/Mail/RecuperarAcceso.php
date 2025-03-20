<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarAcceso extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $temp_password;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $temp_password, $url)
    {
        $this->user = $user;
        $this->temp_password = $temp_password;
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Franquicias Presidenciales - Recuperación de contraseña',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.UserResetPassword',
            with: [
                'temp_password' => $this->temp_password,
                'url' => $this->url,
                'usuario' => [
                    'nombreUsuario' => $this->user->name,
                    'apellidoUsuario' => $this->user->last_name,
                ],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
