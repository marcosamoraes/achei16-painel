<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="relative pt-5">
        <div class="px-4 md:px-10 mx-auto w-full">
            <div>
                <div class="flex flex-wrap">
                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'seller')
                        <div class="w-full mb-10 px-4">
                            <form class="flex flex-wrap gap-5">
                                <div>
                                    <label class="block uppercase text-xs font-bold mb-2" for="initial_date">Data
                                        Inicial</label>
                                    <input type="date" id="initial_date" name="initial_date"
                                        value="{{ request()->initial_date ??now()->subDays(30)->format('Y-m-d') }}"
                                        class="border-0 px-3 py-3 text-black bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" />
                                </div>
                                <div>
                                    <label class="block uppercase text-xs font-bold mb-2" for="final_date">Data
                                        Final</label>
                                    <input type="date" id="final_date" name="final_date"
                                        value="{{ request()->final_date ?? now()->format('Y-m-d') }}"
                                        class="border-0 px-3 py-3 text-black placeholder-dark bg-white rounded text-sm shadow focus:outline-none focus:ring w-full" />
                                </div>
                                <div>
                                    <button
                                        class="bg-primary-500 text-white mt-6 active:bg-primary-500 font-bold uppercase text-xs px-4 py-3 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1"
                                        type="submit" style="transition: all 0.15s ease">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="w-full"></div>
                    @endif
                    @if (auth()->user()->role === 'admin')
                        <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                            <a href="/clients">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Clientes</h5><span
                                                    class="font-semibold text-xl text-black">{{ $countClients }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                                    <i class="fa fa-users"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                            <a href="/companies?status=1">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Empresas Ativas</h5>
                                                <span
                                                    class="font-semibold text-xl text-black">{{ $countActiveCompanies }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-orange-500">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                            <a href="/companies?status=0">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Empresas Inativas
                                                </h5><span
                                                    class="font-semibold text-xl text-black">{{ $countInactiveCompanies }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-yellow-500">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                            <a href="/sellers">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Vendedores</h5><span
                                                    class="font-semibold text-xl text-black">{{ $countSellers }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-pink-500">
                                                    <i class="fas fa-users-gear"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-3/12 px-4 mt-3">
                            <a href="/orders">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Vendas</h5><span
                                                    class="font-semibold text-xl text-black">R$
                                                    {{ number_format($sumOrdersTotal, 2, ',', '.') }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500">
                                                    <i class="fa fa-cart-shopping"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-3/12 px-4 mt-3">
                            <a href="/contacts">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Contatos</h5><span
                                                    class="font-semibold text-xl text-black">{{ $countContacts }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-black">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-3/12 px-4 mt-3">
                            <a href="/registers">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Interessados (Leads)
                                                </h5><span
                                                    class="font-semibold text-xl text-black">{{ $countRegisters }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-cyan-500">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="w-full px-4 pt-10">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                <div class="flex-auto p-4">
                                    <div class="flex flex-wrap">
                                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                            <h5 class="text-black uppercase font-bold text-xs">Estabelecimentos por
                                                cidade</h5>
                                            <div id="chart-container" class="mt-3">
                                                <canvas class="chart" data-type="bar"
                                                    data-labels="[{!! $companiesPerCityLabels !!}]"
                                                    data-series="[{{ $companiesPerCityValues }}]"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->role === 'seller')
                        <div class="w-full lg:w-6/12 xl:w-4/12 px-4 mt-3">
                            <a href="/companies?status=1">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Empresas Ativas</h5>
                                                <span
                                                    class="font-semibold text-xl text-black">{{ $countActiveCompanies }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-orange-500">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-4/12 px-4 mt-3">
                            <a href="/companies?status=0">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Empresas Inativas
                                                </h5><span
                                                    class="font-semibold text-xl text-black">{{ $countInactiveCompanies }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-yellow-500">
                                                    <i class="fa fa-building"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-4/12 px-4 mt-3">
                            <a href="/orders">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Vendas</h5><span
                                                    class="font-semibold text-xl text-black">R$
                                                    {{ number_format($sumOrdersTotal, 2, ',', '.') }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500">
                                                    <i class="fa fa-cart-shopping"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </a>
                    @endif

                    @if (auth()->user()->role === 'user')
                        <div class="w-full lg:w-6/12 xl:w-4/12 px-4">
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                <div class="flex-auto p-4">
                                    <div class="flex flex-wrap">
                                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                            <h5 class="text-black uppercase font-bold text-xs">Impressões</h5><span
                                                class="font-semibold text-xl text-black">{{ $countVisits }}</span>
                                        </div>
                                        <div class="relative w-auto pl-4 flex-initial">
                                            <div
                                                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-orange-500">
                                                <i class="fa fa-eye"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 xl:w-4/12 px-4">
                            <a href="/contacts">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Contatos</h5><span
                                                    class="font-semibold text-xl text-black">{{ $countContacts }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-blue-500">
                                                    <i class="fa fa-address-book"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @foreach ($activeCompanies as $activeCompany)
                            <div class="w-full lg:w-6/12 xl:w-4/12 px-4">
                                <div
                                    class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                    <div class="flex-auto p-4">
                                        <div class="flex flex-wrap">
                                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                <h5 class="text-black uppercase font-bold text-xs">Seu Contrato Vence
                                                    Em
                                                    {{ $activeCompanies->count() > 1 ? "- {$activeCompany->name}" : false }}
                                                </h5><span
                                                    class="font-semibold text-xl text-black">{{ $activeCompany->expireAt }}</span>
                                            </div>
                                            <div class="relative w-auto pl-4 flex-initial">
                                                <div
                                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-yellow-500">
                                                    <i class="fa fa-file"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
