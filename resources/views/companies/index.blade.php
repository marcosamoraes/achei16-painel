<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Empresas
        </h2>
        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'seller')
            <a href="{{ route('companies.create') }}"><x-button>Cadastrar</x-button></a>
        @endif
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
                        <option value="{{ $seller->id }}" {{ request()->seller == $seller->id ? 'selected' : false }}>{{ $seller->name }}</option>
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
                    <option value="1" {{ request()->status === '1' ? 'selected' : false }}>Ativo</option>
                    <option value="0" {{ request()->status === '0' ? 'selected' : false }}>Inativo</option>
                </x-form.select>

                <x-form.select id="status_sell" name="status_sell" type="text" class="block" style="min-width: 250px" :value="request()->status_sell"
                    autofocus autocomplete="status_sell">
                    <option value="">Status de Venda</option>
                    <option value="1" {{ request()->status_sell === '1' ? 'selected' : false }}>Ativo</option>
                    <option value="0" {{ request()->status_sell === '0' ? 'selected' : false }}>Inativo</option>
                </x-form.select>

                <div class="flex flex-col">
                    <label for="">Data de criação inicial</label>
                    <x-form.input type="date" name="initial_created_at" :value="request()->initial_created_at" style="min-width: 250px" />
                </div>
                <div class="flex flex-col">
                    <label for="">Data de criação final</label>
                    <x-form.input type="date" name="final_created_at" :value="request()->final_created_at" style="min-width: 250px" />
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
                                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'seller')
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                        <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Cliente</span>
                                    </th>
                                @endif
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Nome</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Telefone</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Cidade</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Status</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Status de venda</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Data de Vencimento</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Data de criação</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Ações</span>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-dark-eval-1 divide-y divide-gray-200 divide-solid">
                            @foreach($companies as $company)
                                <tr class="bg-white dark:bg-dark-eval-1">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $company->id }}
                                    </td>
                                    @if (auth()->user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            {{ $company->user?->name ?? 'Sem vendedor' }}
                                        </td>
                                    @endif
                                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'seller')
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                            {{ $company->client->user->name }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        {{ $company->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        {{ $company->phone }}<br />
                                        {{ $company->phone2 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        {{ "{$company->city}/{$company->state}" }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        @if ($company->status)
                                            <span class="text-green-500">Ativo</span>
                                        @else
                                            <span class="text-red-500">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        @if ($company->is_approved)
                                            <span class="text-green-500">Ativo</span>
                                        @else
                                            <span class="text-red-500">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        {{ $company->lastOrderApproved?->expire_at?->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $company->created_at?->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white flex gap-3">
                                        @if (auth()->user()->role === 'admin')
                                            <a href="https://wa.me/+55{{ preg_replace('/\D/', '', $company->phone) }}" target="_blank">
                                                <x-button variant="whatsapp" title="Whatsapp">
                                                    <i class="fab fa-whatsapp"></i>
                                                </x-button>
                                            </a>
                                        @endif
                                        @if ($company->lastOrderApproved && auth()->user()->role !== 'seller')
                                            <a href="{{ route('orders.contract', $company->lastOrderApproved->uuid) }}" target="_blank">
                                                <x-button variant="black" title="Link do contrato">
                                                    <i class="fas fa-file"></i>
                                                </x-button>
                                            </a>
                                        @endif
                                        <a href="{{ route('companies.edit', $company->id) }}">
                                            <x-button variant="warning">
                                                <i class="fas fa-edit"></i>
                                            </x-button>
                                        </a>
                                        @if (auth()->user()->role === 'admin')
                                            <form method="POST" action="{{ route('companies.destroy', $company->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <x-button variant="danger" onclick="if (!confirm('Você tem certeza que quer deletar?')) return false">
                                                    <i class="fas fa-trash"></i>
                                                </x-button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $companies->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
