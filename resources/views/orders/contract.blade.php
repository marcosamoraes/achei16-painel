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
                    <div class="px-4 py-6 sm:px-0">
                        <h2 class="text-lg font-medium leading-6 text-gray-900">{{ str()->startsWith($order->pack->contract->name, 'Contrato') ? $order->pack->contract->name : "Contrato {$order->pack->contract->name}" }}</h2>
                        <p class="mt-1 text-sm text-gray-600">Por favor, leia atentamente o contrato abaixo e assine para indicar sua concordância.</p>
                    </div>
                    <div class="px-4 py-6 sm:px-0">
                        <div class="border-2 border-gray-300 rounded-lg p-4 w-full">
                            <p class="text-sm text-gray-600">{!! $order->pack->contract->description !!}</p>
                        </div>
                    </div>
                    @if (!$order->contract_url)
                        <div class="px-4 py-6 sm:px-0">
                            <div class="border-2 border-gray-300 rounded-lg p-4">
                                <canvas id="signatureCanvas" height="300" style="background: white;"></canvas>
                                <form id="contractForm" action="{{ route('orders.contract.sign', $order->uuid) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="signature" id="signatureInput">
                                    <button type="submit" class="mt-4 bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Assinar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <img src="/storage/{{ $order->contract_url }}" alt="">
                    @endif
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
    </script>
</body>
</html>
