<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ObservacionFranquicia extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $franquicia;
    private $url;

    /**
     * Create a new message instance.
     */
    public function __construct($franquicia, $url)
    {
        $this->franquicia = $franquicia;
        $this->url = $url;
        $this->user = $franquicia->usuario_creador;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Franquicias Presidenciales - Observación de franquicia',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.UserAuxObservation',
            with: [
                'codigoProvisional' => $this->franquicia->codigo_provisional,
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
