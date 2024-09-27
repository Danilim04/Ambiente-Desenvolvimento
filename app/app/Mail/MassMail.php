<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MassMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $assunto;
    public $mensagem;
    public $nomeCliente;
    public $placaVeiculo;
    public $veiculo;
    public $ultimoContato;
    public $anexos= [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$assunto,$mensagem,$nomeCliente,$placaVeiculo,$veiculo,$ultimoContato,$anexos = [])
    {
        $this->email = $email;
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
        $this->nomeCliente = $nomeCliente;
        $this->placaVeiculo = $placaVeiculo;
        $this->veiculo = $veiculo;
        $this->ultimoContato = $ultimoContato;
        $this->anexos = $anexos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject($this->assunto)
            ->markdown('emails.massmail')
            ->with([
                'messageBody' => $this->mensagem,
            ]);

        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $email->attach(storage_path('app/' . $attachment));
            }
        }

        return $email;
    }
}
