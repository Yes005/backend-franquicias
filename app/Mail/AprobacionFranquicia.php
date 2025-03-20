<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AprobacionFranquicia extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $franquicia;
    private $url;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $franquicia, $url)
    {
        $this->user = $user;
        $this->franquicia = $franquicia;
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Franquicias Presidenciales - Aprobación de franquicia',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.UserAuxAprobed',
            with: [
                'codigoProvisional' => $this->franquicia->codigo_provisional,
                'codigoFranquicia' => $this->franquicia->codigo_franquicia,
                'usuario' => [
                    'nombreUsuario' => $this->user->name,
                    'apellidoUsuario' => $this->user->last_name,
                ],
                'url' => $this->url,
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
