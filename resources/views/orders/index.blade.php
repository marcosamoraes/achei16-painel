<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Vendas
        </h2>
        <a href="{{ route('orders.create') }}"><x-button>Cadastrar</x-button></a>
    </x-slot>

    <x-search-bar />

    <div class="max-w-10xl sm:px-6 lg:px-8 mt-5">
        <div class="flex justify-between">
            <form method="GET" class="flex flex-wrap gap-3 w-full">
                <input type="hidden" name="search" value="{{ request()->search }}">

                <x-form.select id="seller" name="seller" type="text" class="block" style="min-width: 250px" :value="request()->seller"
                    autofocus autocomplete="seller">
                    <option value="">Vendedor</option>
                    @foreach ($sellers as $seller)
                        <option value="{{ $seller->user->id }}" {{ request()->seller == $seller->user_id ? 'selected' : false }}>{{ $seller->user->name }}</option>
                    @endforeach
                </x-form.select>

                <x-form.select id="category" name="category" type="text" class="block" style="min-width: 250px" :value="request()->category"
                    autofocus autocomplete="category">
                    <option value="">Categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : false }}>{{ $category->name }}</option>
                    @endforeach
                </x-form.select>

                <x-form.select id="city" name="city" type="text" class="block" style="min-width: 250px" :value="request()->city"
                    autofocus autocomplete="city">
                    <option value="">Cidade</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" {{ request()->city == $city ? 'selected' : false }}>{{ $city }}</option>
                    @endforeach
                </x-form.select>

                <x-form.select id="status" name="status" type="text" class="block" style="min-width: 250px" :value="request()->status"
                    autofocus autocomplete="status">
                    <option value="">Status</option>
                    <option value="pending" {{ request()->status === 'pending' ? 'selected' : false }}>Pendente</option>
                    <option value="approved" {{ request()->status === 'approved' ? 'selected' : false }}>Aprovado
                    </option>
                    <option value="canceled" {{ request()->status === 'canceled' ? 'selected' : false }}>Cancelado
                    </option>
                </x-form.select>

                <x-form.select id="payment_method" name="payment_method" type="text" class="block" style="min-width: 250px" :value="request()->payment_method"
                    autofocus autocomplete="payment_method">
                    <option value="">Método de Pagamento</option>
                    <option value="dinheiro" {{ request()->payment_method === 'dinheiro' ? 'selected' : false }}>Dinheiro</option>
                    <option value="pix" {{ request()->payment_method === 'pix' ? 'selected' : false }}>Pix</option>
                    <option value="cartão de crédito" {{ request()->payment_method === 'cartão de crédito' ? 'selected' : false }}>Cartão de crédito</option>
                    <option value="cartão de débito" {{ request()->payment_method === 'cartão de débito' ? 'selected' : false }}>Cartão de débito</option>
                    <option value="boleto" {{ request()->payment_method === 'boleto' ? 'selected' : false }}>Boleto</option>
                    <option value="transferência bancária" {{ request()->payment_method === 'transferência bancária' ? 'selected' : false }}>Transferência bancária</option>
                </x-form.select>

                <div class="flex flex-col">
                    <label for="">Data de aprovação inicial</label>
                    <x-form.input type="date" name="initial_approved_at" :value="request()->initial_approved_at" style="min-width: 250px" />
                </div>
                <div class="flex flex-col">
                    <label for="">Data de aprovação final</label>
                    <x-form.input type="date" name="final_approved_at" :value="request()->final_approved_at" style="min-width: 250px" />
                </div>
                <div class="flex flex-col">
                    <label for="">Data de expiração inicial</label>
                    <x-form.input type="date" name="initial_expire_at" :value="request()->initial_expire_at" style="min-width: 250px" />
                </div>
                <div class="flex flex-col">
                    <label for="">Data de expiração final</label>
                    <x-form.input type="date" name="final_expire_at" :value="request()->final_expire_at" style="min-width: 250px" />
                </div>

                <x-button>
                    <i class="fas fa-search"></i>
                </x-button>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-dark-eval-1 overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="overflow-hidden overflow-x-auto p-6 bg-white dark:bg-dark-eval-1 border-b border-gray-200 dark:border-dark-eval-1">
                    <div class="min-w-full align-middle">
                        <table
                            class="min-w-full divide-y divide-gray-200 dark:divide-gray-500 border dark:border-gray-500 mt-5">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">ID</span>
                                    </th>
                                    @if (auth()->user()->role === 'admin')
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                            <span
                                                class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Vendedor</span>
                                        </th>
                                    @endif
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Empresa</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Cidade</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Pacote</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Valor</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Data
                                            de aprovação</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Vence
                                            em</span>
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Status</span>
                                    </th>
                                    @if (auth()->user()->role === 'admin')
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                            <span
                                                class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Ações</span>
                                        </th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-dark-eval-1 divide-y divide-gray-200 divide-solid">
                                @foreach ($orders as $order)
                                    <tr class="bg-white dark:bg-dark-eval-1">
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                            {{ $order->id }}
                                        </td>
                                        @if (auth()->user()->role === 'admin')
                                            <td
                                                class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                                {{ $order->user->name ?? 'Sem vendedor' }}
                                            </td>
                                        @endif
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            {{ $order->company->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            {{ "{$order->company->city}/{$order->company->state}" }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            {{ $order->pack->title }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            R$ {{ number_format($order->value, 2, ',', '.') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                            @if ($order->approved_at)
                                                <span>{{ $order->approved_at?->format('d/m/Y H:i:s') }}</span>
                                            @elseif ($order->canceled_at)
                                                <span>{{ $order->canceled_at?->format('d/m/Y H:i:s') }}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                            {{ $order->expire_at?->format('d/m/Y') ?? '-' }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            <b>
                                                @if ($order->status === 'pending')
                                                    <span
                                                        style="color: rgb(234 179 8 / var(--tw-text-opacity));">Pendente</span>
                                                @elseif ($order->status === 'approved')
                                                    <span class="text-green-500">Aprovado</span>
                                                @elseif ($order->status === 'canceled')
                                                    <span class="text-red-500">Cancelado</span>
                                                @else
                                                    <span class="text-gray-500">Reembolsado</span>
                                                @endif
                                            </b>
                                        </td>
                                        @if (auth()->user()->role === 'admin')
                                            <td
                                                class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white flex gap-3">
                                                @if ($order->contract_url)
                                                    <a href="{{ route('orders.contract', $order->uuid) }}"
                                                        target="_blank">
                                                        <x-button variant="primary" title="Assinatura do contrato">
                                                            <i class="fas fa-file"></i>
                                                        </x-button>
                                                    </a>
                                                @else
                                                    <a href="https://wa.me/+55{{ preg_replace('/\D/', '', ($order->company->client->phone2 ?? $order->company->client->phone)) }}?text=Link do contrato do Achei16: {{ route('orders.contract', $order->uuid) }}"
                                                        target="_blank">
                                                        <x-button variant="whatsapp" title="Link do contrato">
                                                            <i class="fab fa-whatsapp"></i>
                                                        </x-button>
                                                    </a>
                                                    <a href="{{ route('orders.contract', $order->uuid) }}"
                                                        target="_blank">
                                                        <x-button variant="black" title="Link do contrato">
                                                            <i class="fas fa-file"></i>
                                                        </x-button>
                                                    </a>
                                                @endif
                                                @if ($order->status === 'pending')
                                                    <a href="{{ route('orders.payment.generate', $order->id) }}"
                                                        target="_blank">
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
