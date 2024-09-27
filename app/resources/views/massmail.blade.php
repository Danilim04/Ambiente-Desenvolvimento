<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Envio de E-mails em Massa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('massmail.send') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Campo: Assunto -->
                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium text-gray-700">Assunto</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Campo: Mensagem -->
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensagem</label>
                            <textarea name="message" id="message" rows="5" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('message') }}</textarea>
                        </div>

                        <!-- Campo: Anexos -->
                        <div class="mb-4">
                            <label for="attachments" class="block text-sm font-medium text-gray-700">Anexos (Opcional)</label>
                            <input type="file" name="attachments[]" id="attachments" multiple
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100">
                            <p class="mt-2 text-sm text-gray-500">Formatos permitidos: PDF, JPG, PNG, DOC, DOCX, XLS, XLSX, CSV. Tamanho máximo: 2MB por arquivo.</p>
                        </div>

                        <!-- Campo: Planilha com E-mails dos Destinatários -->
                        <div class="mb-4">
                            <label for="spreadsheet" class="block text-sm font-medium text-gray-700">Planilha com E-mails dos Destinatários</label>
                            <input type="file" name="spreadsheet" id="spreadsheet" required
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100">
                            <p class="mt-2 text-sm text-gray-500">Formatos aceitos: XLSX, XLS, CSV. E-mails devem estar na primeira coluna.</p>
                        </div>

                        <!-- Botão de Envio -->
                        <div>
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enviar E-mails
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
