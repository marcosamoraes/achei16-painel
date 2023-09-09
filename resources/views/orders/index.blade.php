<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Vendas
        </h2>
        <a href="{{ route('orders.create') }}"><x-button>Cadastrar</x-button></a>
    </x-slot>

    <x-search-bar />

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-dark-eval-1 border-b border-gray-200 dark:border-dark-eval-1">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-500 border dark:border-gray-500 mt-5">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">ID</span>
                                </th>
                                @if (auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Vendedor</span>
                                    </th>
                                @endif
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Empresa</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Pacote</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Valor</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Vence em</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Status</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Data de aprovação/cancelamento</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Data de criação</span>
                                </th>
                                @if (auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                        <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Ações</span>
                                    </th>
                                @endif
                            </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-dark-eval-1 divide-y divide-gray-200 divide-solid">
                            @foreach($orders as $order)
                                <tr class="bg-white dark:bg-dark-eval-1">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $order->id }}
                                    </td>
                                    @if (auth()->user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            {{ $order->user->name ?? 'Sem vendedor' }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        {{ $order->company->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        {{ $order->pack->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        R$ {{ number_format($order->value, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $order->expire_at?->format('d/m/Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        @if ($order->status === 'pending')
                                            <span>Pendente</span>
                                        @elseif ($order->status === 'approved')
                                            <span>Aprovado</span>
                                        @elseif ($order->status === 'canceled')
                                            <span>Cancelado</span>
                                        @else
                                            <span>Reembolsado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        @if ($order->approved_at)
                                            <span>{{ $order->approved_at?->format('d/m/Y H:i:s') }}</span>
                                        @elseif ($order->canceled_at)
                                            <span>{{ $order->canceled_at?->format('d/m/Y H:i:s') }}</span>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $order->created_at?->format('d/m/Y H:i:s') }}
                                    </td>
                                    @if (auth()->user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white flex gap-3">
                                            @if ($order->status === 'pending')
                                                <a href="{{ route('orders.payment.generate', $order->id) }}" target="_blank">
                                                    <x-button variant="info" title="gerar link para pagamento">
                                                        <i class="fas fa-money-bill"></i>
                                                    </x-button>
                                                </a>
                                            @endif
                                            <a href="{{ route('orders.edit', $order->id) }}">
                                                <x-button variant="warning">
                                                    <i class="fas fa-edit"></i>
                                                </x-button>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
