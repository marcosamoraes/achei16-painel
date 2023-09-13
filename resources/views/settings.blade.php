<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Meus Dados
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <form
                method="post"
                action="{{ route('settings.update') }}"
            >
                @csrf
                @method('PUT')

                <div class="mb-5 grid grid-cols-1 sm:grid-cols-3 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="cpf_cnpj"
                            :value="__('CPF/CNPJ *')"
                        />

                        <x-form.input
                            id="cpf_cnpj"
                            name="cpf_cnpj"
                            type="text"
                            class="block w-full"
                            :value="old('cpf_cnpj', $client->cpf_cnpj)"
                            x-mask:dynamic="cpfCnpjMask"
                            autofocus
                            required
                            autocomplete="cpf_cnpj"
                        />

                        <x-form.error :messages="$errors->get('cpf_cnpj')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="phone"
                            :value="__('Telefone *')"
                        />

                        <x-form.input
                            id="phone"
                            name="phone"
                            type="text"
                            class="block w-full"
                            :value="old('phone', $client->phone)"
                            x-mask:dynamic="phoneMask"
                            autofocus
                            required
                            autocomplete="phone"
                        />

                        <x-form.error :messages="$errors->get('phone')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="phone2"
                            :value="__('Whatsapp')"
                        />

                        <x-form.input
                            id="phone2"
                            name="phone2"
                            type="text"
                            class="block w-full"
                            :value="old('phone2', $client->phone2)"
                            x-mask:dynamic="phoneMask"
                            autofocus
                            autocomplete="phone2"
                        />

                        <x-form.error :messages="$errors->get('phone2')" />
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 sm:grid-cols-3 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="cep"
                            :value="__('CEP')"
                        />

                        <x-form.input
                            id="cep"
                            name="cep"
                            type="text"
                            class="block w-full"
                            :value="old('cep', $client->cep)"
                            x-mask="99999-999"
                            autofocus
                            autocomplete="cep"
                            x-on:keyup="getAddressByCep()"
                            x-model="cep"
                            x-ref="cep"
                        />

                        <x-form.error :messages="$errors->get('cep')" />
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 sm:grid-cols-3 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="address"
                            :value="__('Endereço')"
                        />

                        <x-form.input
                            id="address"
                            name="address"
                            type="text"
                            class="block w-full"
                            :value="old('address', $client->address)"
                            autofocus
                            autocomplete="address"
                            x-model="address"
                        />

                        <x-form.error :messages="$errors->get('address')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="number"
                            :value="__('Número')"
                        />

                        <x-form.input
                            id="number"
                            name="number"
                            type="text"
                            class="block w-full"
                            :value="old('number', $client->number)"
                            autofocus
                            autocomplete="number"
                            x-model="number"
                        />

                        <x-form.error :messages="$errors->get('number')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="complement"
                            :value="__('Complemento')"
                        />

                        <x-form.input
                            id="complement"
                            name="complement"
                            type="text"
                            class="block w-full"
                            :value="old('complement', $client->complement)"
                            autofocus
                            autocomplete="complement"
                            x-model="complement"
                        />

                        <x-form.error :messages="$errors->get('complement')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="neighborhood"
                            :value="__('Bairro')"
                        />

                        <x-form.input
                            id="neighborhood"
                            name="neighborhood"
                            type="text"
                            class="block w-full"
                            :value="old('neighborhood', $client->neighborhood)"
                            autofocus
                            autocomplete="neighborhood"
                            x-model="neighborhood"
                        />

                        <x-form.error :messages="$errors->get('neighborhood')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="city"
                            :value="__('Cidade')"
                        />

                        <x-form.input
                            id="city"
                            name="city"
                            type="text"
                            class="block w-full"
                            :value="old('city', $client->city)"
                            autofocus
                            autocomplete="city"
                            x-model="city"
                        />

                        <x-form.error :messages="$errors->get('city')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="state"
                            :value="__('Estado')"
                        />

                        <x-form.input
                            id="state"
                            name="state"
                            type="text"
                            class="block w-full"
                            :value="old('state', $client->state)"
                            autofocus
                            autocomplete="state"
                            x-model="state"
                        />

                        <x-form.error :messages="$errors->get('state')" />
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
