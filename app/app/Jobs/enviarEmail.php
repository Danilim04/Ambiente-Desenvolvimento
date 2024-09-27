<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\MassMail;

class enviarEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $assunto;
    public $mensagem;
    public $nomeCliente;
    public $placaVeiculo;
    public $veiculo;
    public $ultimoContato;
    public $anexos = [];
    /**
     * Create a new job instance.
     */
    public function __construct($email, $assunto, $mensagem, $nomeCliente, $placaVeiculo, $veiculo, $ultimoContato, $anexos = [])
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
     * Execute the job.
     */
    public function handle(): void
    {

        if (!empty($this->anexos)) {
            Mail::to($this->email)->send(new MassMail($this->email, $this->assunto, $this->mensagem, $this->nomeCliente, $this->placaVeiculo, $this->veiculo, $this->ultimoContato, $this->anexos));
        }
        Mail::to($this->email)->send(new MassMail($this->email, $this->assunto, $this->mensagem, $this->nomeCliente, $this->placaVeiculo, $this->veiculo, $this->ultimoContato));

    }
}
