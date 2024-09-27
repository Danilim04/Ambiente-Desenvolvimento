@component('mail::message')

{{-- Logo da Empresa --}}
<!-- <div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" width="150">
</div> -->

{{-- Saudação --}}
Olá, {{ $nomeCliente }},

{{$mensagem}}

{{-- Corpo da Mensagem --}}
Placa do Veiculo:**{{ strtoupper($placaVeiculo) }}**.
ultima localização:**{{ strtoupper($ultimoContato) }}**.


{{-- Botão de Ação: Enviar Mensagem no WhatsApp --}}
@component('mail::button', ['url' => "https://wa.me/5531983857490?text=Recebi%20um%20e-mail%20%20de%20cobran%C3%A7a%2C%20gostaria%20de%20realizar%20o%20pagamento", 'color' => 'blue'])
Falar conosco
@endcomponent

{{-- Nota Adicional --}}
Isso é o email automatico, por favor não responda, use o botão do WhatsApp para falar com a equipe responsavel
{{-- Encerramento --}}
Agradecemos pela sua atenção.

{{-- Assinatura --}}
Atenciosamente

{{-- Rodapé --}}
@endcomponent
