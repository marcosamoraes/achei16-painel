<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    {{-- Select 2 --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div
        x-data="mainState"
        class="font-sans antialiased"
        :class="{dark: isDarkMode}"
        x-cloak
    >
        <div class="flex flex-col min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
            <div class="flex flex-col min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="flex justify-center">
                        <x-application-logo class="h-20" />
                    </div>
                    <div class="px-4 py-6 sm:px-0">
                        <h2 class="text-lg font-medium leading-6 text-gray-900">{{ str()->startsWith($order->pack->contract->name, 'Contrato') ? $order->pack->contract->name : "Contrato {$order->pack->contract->name}" }}</h2>
                        <p class="mt-1 text-sm text-gray-600">Por favor, leia atentamente o contrato abaixo e assine para indicar sua concordância.</p>
                    </div>
                    <div class="px-4 py-6 sm:px-0">
                        <div class="border-2 border-gray-300 rounded-lg p-4 w-full">
                            <p class="text-sm text-gray-600"><b>CONTRATADA: ACHEI 16, inscrita no CNPJ 18.752.155/0001-40 representada por Leonardo Tosetto Leal, CPF 374.947.196-30, situado na rua Ana Rita Camacho, 195, Vila Elmaz, São José do Rio Preto, São Paulo.</b></p><br/>
                            <p class="text-sm text-gray-600"><b>CONTRATANTE: {{ $order->company->client->user->name }}, inscrita no {{ strlen($order->company->client->cpf_cnpj) > 14 ? 'CNPJ' : 'CPF' }} {{ $order->company->client->cpf_cnpj }}, situado na rua {{ $order->company->client->full_address }}.</b></p><br/>
                            <p class="text-sm text-gray-600"><b>VALOR: R${{ number_format($order->value, 2, ',', '.') }}</b></p><br/>
                            <p class="text-sm text-gray-600">{!! $order->pack->contract->description !!}</p>
                        </div>
                    </div>
                    <div class="px-4 py-6 sm:px-0">
                        <div class="border-2 border-gray-300 rounded-lg p-4">
                            <form id="contractForm" action="{{ route('orders.contract.sign', $order->uuid) }}" class="grid grid-cols gap-y-6 gap-x-4" method="POST">
                                @csrf

                                <div class="mb-5 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                                    <div class="space-y-2">
                                        <x-form.label for="contract_name" :value="__('Nome *')" />

                                        <x-form.input
                                            id="contract_name"
                                            name="contract_name"
                                            type="text"
                                            class="block w-full"
                                            :value="old('contract_name', $order->contract_name)"
                                            required
                                            autofocus
                                            autocomplete="contract_name"
                                            disabled="{{ $order->contract_url }}"
                                        />

                                        <x-form.error :messages="$errors->get('contract_name')" />
                                    </div>

                                    <div class="space-y-2">
                                        <x-form.label for="contract_cpf" :value="__('CPF *')" />

                                        <x-form.input
                                            id="contract_cpf"
                                            name="contract_cpf"
                                            type="text"
                                            class="block w-full"
                                            :value="old('contract_cpf', $order->contract_cpf)"
                                            x-mask:dynamic="cpfCnpjMask"
                                            maxlength="14"
                                            autofocus
                                            required
                                            autocomplete="client[contract_cpf]"
                                            disabled="{{ $order->contract_url }}"
                                        />

                                        <x-form.error :messages="$errors->get('contract_cpf')" />
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    @if (!$order->contract_url)
                                        <x-form.label for="signatureCanvas" :value="__('Assine digitalmente o seu nome ou assinatura')" />
                                        <canvas id="signatureCanvas" height="300" style="background: white;"></canvas>
                                    @else
                                        <p><i><b>Assinado digitalmente às {{ $order->contract_signed_at?->format('d/m/Y h:i:s') }} - IP {{ $order->contract_ip }}</b></i></p>
                                        <img src="/storage/{{ $order->contract_url }}" alt="">
                                        <img src="/storage/public/{{ $order->contract_url }}" alt="">
                                    @endif
                                </div>

                                <input type="hidden" name="signature" id="signatureInput">
                                @if (!$order->contract_url)
                                    <div class="flex justify-center items-center gap-3">
                                        <button type="submit" class="w-full mt-4 bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Assinar</button>
                                        <button type="button" id="clearSignature" class="w-full mt-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Limpar</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://unpkg.com/signature_pad"></script>
    <script>
        const form = document.getElementById('contractForm');
        const signatureInput = document.getElementById('signatureInput');
        const signatureCanvas = document.getElementById('signatureCanvas');
        const signaturePad = new SignaturePad(signatureCanvas);

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            signatureInput.value = signaturePad.toDataURL();
            form.submit();
        });

        const clearButton = document.getElementById('clearSignature');

        clearButton.addEventListener('click', function(event) {
            signaturePad.clear();
        });
    </script>
</body>
</html>
