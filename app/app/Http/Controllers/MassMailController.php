<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MassMail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Jobs\enviarEmail;
use Exception;

class MassMailController extends Controller
{
    /**
     * Mostra o formulário de envio de e-mails em massa.
     */
    public function showForm()
    {
        return view('massmail');
    }

    /**
     * Processa o envio de e-mails em massa.
     */
    public function sendMassMail(Request $request)
    {

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'anexos.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,csv|max:10048',
            'spreadsheet' => 'required|file|mimes:xlsx,xls,csv|max:10048',
        ]);

        $assunto = $request->input('subject');
        $mensagem = $request->input('message');
        $spreadsheet = $request->file('spreadsheet');
        $anexos = [];

        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $file) {
                $path = $file->store('attachments');
                $anexos[] = $path;
            }
        }


        $spreadsheetPath = $spreadsheet->store('spreadsheets');
        try {
            $data = Excel::toArray([], storage_path('app/' . $spreadsheetPath));
            $clients = [];
            foreach ($data[0] as $row) {
                $email = trim($row[0]);
                $nomeCliente = trim($row[1]);
                $placaVeiculo = trim($row[2]);
                $veiculo = trim($row[3]);
                $ultimoContato = trim($row[4]);

                // Validação básica do e-mail e telefone
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    enviarEmail::dispatch(
                        $email,
                        $assunto,
                        $mensagem,
                        $nomeCliente,
                        $placaVeiculo,
                        $veiculo,
                        $ultimoContato,
                        $anexos
                    )->onQueue('high');
                }
             
            }
        } catch (Exception $e) {
            return back()->withErrors(['erro'=> 'houve algum erro inesperado, por favor entre contato com o suporte','mensagemErro' => $e->getMessage()]);
        }

        return back()->with('success', 'E-mails enviados com sucesso!');
    }
}
