<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudFranquicia extends Mailable
{
    use Queueable, SerializesModels;

    public $franquicia;
    public $url;
    public $jefe;

    /**
     * Create a new message instance.
     */
    public function __construct($franquicia, $url, $jefe)
    {
        $this->franquicia = $franquicia;
        $this->url = $url;
        $this->jefe = $jefe;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Franquicias Presidenciales - Solicitud de franquicia',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.UserBossNewRequest',
            with: [
                'codigoProvisional' => $this->franquicia->codigo_provisional,
                'usuario' => [
                    'nombreUsuario' => $this->jefe->name,
                    'apellidoUsuario' => $this->jefe->last_name,
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
