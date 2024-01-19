<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\CadastroPremio;

class NovoPremioCadastradoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $premio;
    public $quantidade;

    public function __construct(User $user, CadastroPremio $premio, int $quantidade)
    {
        $this->user = $user;
        $this->premio = $premio;
        $this->quantidade = $quantidade;
    }

    public function build()
    {
        return $this->view('emails.novo_premio_cadastrado');
    }

    /**
     * Get the message envelope.
     */
    /* public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo Premio Cadastrado Mail',
        );
    } */

    /**
     * Get the message content definition.
     */
    /* public function content(): Content
    {
        return new Content(
            view: 'novo_premio_cadastrado',
        );
    } */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
   /*  public function attachments(): array
    {
        return [];
    } */
}
