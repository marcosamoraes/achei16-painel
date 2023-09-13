<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>
    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')"
    >
        <x-slot name="icon">
            <i class="fa fa-dashboard" aria-hidden="true"></i>
        </x-slot>
    </x-sidebar.link>

    @if (auth()->user()->role === 'admin')
        <x-sidebar.link
            title="Vendedores"
            href="{{ route('sellers.index') }}"
            :isActive="request()->routeIs('sellers.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-users-gear" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="Contratos"
            href="{{ route('contracts.index') }}"
            :isActive="request()->routeIs('contracts.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-file" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="Pacotes"
            href="{{ route('packs.index') }}"
            :isActive="request()->routeIs('packs.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-box" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
    @endif

    @if (auth()->user()->role === 'seller' || auth()->user()->role === 'admin')
        <x-sidebar.link
            title="Clientes"
            href="{{ route('clients.index') }}"
            :isActive="request()->routeIs('clients.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
    @endif

    <x-sidebar.link
        title="Empresas"
        href="{{ route('companies.index') }}"
        :isActive="request()->routeIs('companies.*')"
    >
        <x-slot name="icon">
            <i class="fa fa-building" aria-hidden="true"></i>
        </x-slot>
    </x-sidebar.link>


    @if (auth()->user()->role === 'seller' || auth()->user()->role === 'admin')
        <x-sidebar.link
            title="Vendas"
            href="{{ route('orders.index') }}"
            :isActive="request()->routeIs('orders.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-cart-shopping" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
    @endif

    @if (auth()->user()->role === 'user')
        <x-sidebar.link
            title="Meus Dados"
            href="{{ route('settings') }}"
            :isActive="request()->routeIs('settings')"
        >
            <x-slot name="icon">
                <i class="fa fa-user" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
    @endif

    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'user')
        <x-sidebar.link
            title="Contatos"
            href="{{ route('contacts.index') }}"
            :isActive="request()->routeIs('contacts.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-file" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
    @endif

    @if (auth()->user()->role === 'admin')
        <x-sidebar.link
            title="Categorias"
            href="{{ route('categories.index') }}"
            :isActive="request()->routeIs('categories.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-tag" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>

        <x-sidebar.link
            title="Banners"
            href="{{ route('banners.index') }}"
            :isActive="request()->routeIs('banners.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-image" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>

        <x-sidebar.link
            title="Interessados"
            href="{{ route('registers.index') }}"
            :isActive="request()->routeIs('registers.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-file" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>

        <x-sidebar.link
            title="Avaliações"
            href="{{ route('reviews.index') }}"
            :isActive="request()->routeIs('reviews.*')"
        >
            <x-slot name="icon">
                <i class="fa fa-star" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
    @endif

    <!-- Authentication -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-sidebar.link
            :href="route('logout')"
            title="Sair"
            onclick="event.preventDefault(); this.closest('form').submit();"
        >
            <x-slot name="icon">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
            </x-slot>
        </x-sidebar.link>
    </form>

</x-perfect-scrollbar>
