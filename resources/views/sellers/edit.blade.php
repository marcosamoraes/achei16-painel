<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Editar vendedor {{ "#{$seller->id} - {$seller->user->name}" }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <form
                method="post"
                action="{{ route('sellers.update', $seller->id) }}"
            >
                @csrf
                @method('PUT')

                <div class="mb-5 grid grid-cols-1 sm:grid-cols-3 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="name"
                            :value="__('Nome *')"
                        />

                        <x-form.input
                            id="name"
                            name="name"
                            type="text"
                            class="block w-full"
                            :value="old('name', $seller->user->name)"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <x-form.error :messages="$errors->get('name')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="email"
                            :value="__('E-mail *')"
                        />

                        <x-form.input
                            id="email"
                            name="email"
                            type="email"
                            class="block w-full"
                            :value="old('email', $seller->user->email)"
                            required
                            autofocus
                            autocomplete="email"
                        />

                        <x-form.error :messages="$errors->get('email')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="status"
                            :value="__('Status *')"
                        />

                        <x-form.select-status name="status" :value="old('status', $seller->user->status)" />
                        <x-form.error :messages="$errors->get('status')" />
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 sm:grid-cols-5 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="cpf"
                            :value="__('CPF')"
                        />

                        <x-form.input
                            id="cpf"
                            name="seller[cpf]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.cpf', $seller->cpf)"
                            x-mask="999.999.999-99"
                            autofocus
                            autocomplete="seller[cpf]"
                        />

                        <x-form.error :messages="$errors->get('seller.cpf')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="rg"
                            :value="__('RG')"
                        />

                        <x-form.input
                            id="rg"
                            name="seller[rg]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.rg', $seller->rg)"
                            x-mask="99.999.999-9"
                            autofocus
                            autocomplete="seller[rg]"
                        />

                        <x-form.error :messages="$errors->get('seller.rg')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="birth_date"
                            :value="__('Data de Nascimento')"
                        />

                        <x-form.input
                            id="birth_date"
                            name="seller[birth_date]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.birth_date', $seller->birth_date->format('d/m/Y'))"
                            x-mask="99/99/9999"
                            autofocus
                            autocomplete="seller[birth_date]"
                        />

                        <x-form.error :messages="$errors->get('seller.birth_date')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="phone"
                            :value="__('Telefone')"
                        />

                        <x-form.input
                            id="phone"
                            name="seller[phone]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.phone', $seller->phone)"
                            x-mask:dynamic="phoneMask"
                            autofocus
                            autocomplete="seller[phone]"
                        />

                        <x-form.error :messages="$errors->get('seller.phone')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="commission"
                            :value="__('Comissão')"
                        />

                        <x-form.input-with-icon-wrapper>
                            <x-slot name="icon">
                                <i class="fa-solid fa-percentage"></i>
                            </x-slot>

                            <x-form.input
                                withicon
                                id="commission"
                                name="seller[commission]"
                                type="text"
                                class="block w-full"
                                :value="old('seller.commission', $seller->commission)"
                                x-mask="99"
                                autofocus
                                autocomplete="seller[commission]"
                            />
                        </x-form.input-with-icon-wrapper>

                        <x-form.error :messages="$errors->get('seller.commission')" />
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
                            name="seller[cep]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.cep', $seller->cep)"
                            x-mask="99999-999"
                            autofocus
                            autocomplete="seller[cep]"
                            x-on:keyup="getAddressByCep()"
                            x-model="cep"
                            x-ref="cep"
                        />

                        <x-form.error :messages="$errors->get('seller.cep')" />
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
                            name="seller[address]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.address', $seller->address)"
                            autofocus
                            autocomplete="seller[address]"
                            x-model="address"
                        />

                        <x-form.error :messages="$errors->get('seller.address')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="number"
                            :value="__('Número')"
                        />

                        <x-form.input
                            id="number"
                            name="seller[number]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.number', $seller->number)"
                            autofocus
                            autocomplete="seller[number]"
                            x-model="number"
                        />

                        <x-form.error :messages="$errors->get('seller.number')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="complement"
                            :value="__('Complemento')"
                        />

                        <x-form.input
                            id="complement"
                            name="seller[complement]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.complement', $seller->complement)"
                            autofocus
                            autocomplete="seller[complement]"
                            x-model="complement"
                        />

                        <x-form.error :messages="$errors->get('seller.complement')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="neighborhood"
                            :value="__('Bairro')"
                        />

                        <x-form.input
                            id="neighborhood"
                            name="seller[neighborhood]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.neighborhood', $seller->neighborhood)"
                            autofocus
                            autocomplete="seller[neighborhood]"
                            x-model="neighborhood"
                        />

                        <x-form.error :messages="$errors->get('seller.neighborhood')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="city"
                            :value="__('Cidade')"
                        />

                        <x-form.input
                            id="city"
                            name="seller[city]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.city', $seller->city)"
                            autofocus
                            autocomplete="seller[city]"
                            x-model="city"
                        />

                        <x-form.error :messages="$errors->get('seller.city')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="state"
                            :value="__('Estado')"
                        />

                        <x-form.input
                            id="state"
                            name="seller[state]"
                            type="text"
                            class="block w-full"
                            :value="old('seller.state', $seller->state)"
                            autofocus
                            autocomplete="seller[state]"
                            x-model="state"
                        />

                        <x-form.error :messages="$errors->get('seller.state')" />
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
