<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Cadastrar venda
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <form
                method="post"
                action="{{ route('orders.store') }}"
            >
                @csrf

                <div class="mb-5 grid grid-cols-1 sm:grid-cols-4 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="company_id"
                            :value="__('Empresa *')"
                        />

                        <x-form.select
                            id="company_id"
                            name="company_id"
                            type="text"
                            class="block w-full select2"
                            :value="old('company_id')"
                            required
                            autofocus
                            autocomplete="company_id"
                        >
                            <option value="">Selecione</option>
                            @foreach ( $companies as $company )
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </x-form.select>

                        <x-form.error :messages="$errors->get('company_id')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="pack_id"
                            :value="__('Pacote *')"
                        />

                        <x-form.select
                            id="pack_id"
                            name="pack_id"
                            type="text"
                            class="block w-full"
                            :value="old('pack_id')"
                            required
                            autofocus
                            autocomplete="pack_id"
                        >
                            <option value="">Selecione</option>
                            @foreach ( $packs as $pack )
                                <option value="{{ $pack->id }}">{{ $pack->title }}</option>
                            @endforeach
                        </x-form.select>

                        <x-form.error :messages="$errors->get('pack_id')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="value"
                            :value="__('Valor *')"
                        />

                        <x-form.input-with-icon-wrapper>
                            <x-slot name="icon">
                                <i class="fa-solid fa-brazilian-real-sign"></i>
                            </x-slot>

                            <x-form.input
                                withicon
                                id="value"
                                name="value"
                                type="text"
                                class="block w-full"
                                :value="old('value')"
                                x-mask:dynamic="$money($input, ',', '.', 2)"
                                required
                                autofocus
                                autocomplete="value"
                            />
                        </x-form.input-with-icon-wrapper>

                        <x-form.error :messages="$errors->get('value')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label for="payment_method" :value="__('Método de Pagamento')" />

                        <x-form.select
                            id="payment_method"
                            name="payment_method"
                            type="text"
                            class="block w-full select2-multiple"
                            autofocus
                            autocomplete="payment_method"
                        >
                            <option value="">Selecione</option>
                            <option value="dinheiro" {{ 'dinheiro' === old('payment_method') ? 'selected' : false }}>Dinheiro</option>
                            <option value="pix" {{ 'pix' === old('payment_method') ? 'selected' : false }}>Pix</option>
                            <option value="cartão de crédito" {{ 'cartão de crédito' === old('payment_method') ? 'selected' : false }}>Cartão de crédito</option>
                            <option value="cartão de débito" {{ 'cartão de débito' === old('payment_method') ? 'selected' : false }}>Cartão de débito</option>
                            <option value="boleto" {{ 'boleto' === old('payment_method') ? 'selected' : false }}>Boleto</option>
                            <option value="transferência bancária" {{ 'transferência bancária' === old('payment_method') ? 'selected' : false }}>Transferência bancária</option>
                        </x-form.select>

                        <x-form.error :messages="$errors->get('payment_method')" />
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <x-button>
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
