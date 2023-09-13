<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Cadastrar pacote
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <form
                method="post"
                action="{{ route('packs.store') }}"
            >
                @csrf

                <div class="mb-5 grid grid-cols-1 sm:grid-cols-3 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="contract_id"
                            :value="__('Contrato *')"
                        />

                        <x-form.select
                            id="contract_id"
                            name="contract_id"
                            type="text"
                            class="block w-full"
                            :value="old('contract_id')"
                            required
                            autofocus
                            autocomplete="contract_id"
                        >
                            <option value="">Selecione</option>
                            @foreach ( $contracts as $contract )
                                <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                            @endforeach
                        </x-form.select>

                        <x-form.error :messages="$errors->get('contract_id')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="title"
                            :value="__('Título *')"
                        />

                        <x-form.input
                            id="title"
                            name="title"
                            type="text"
                            class="block w-full"
                            :value="old('title')"
                            required
                            autofocus
                            autocomplete="title"
                        />

                        <x-form.error :messages="$errors->get('title')" />
                    </div>

                    <div class="space-y-2">
                        <x-form.label
                            for="validity"
                            :value="__('Validade *')"
                        />

                        <x-form.select
                            id="validity"
                            name="validity"
                            type="text"
                            class="block w-full"
                            :value="old('validity')"
                            required
                            autofocus
                            autocomplete="validity"
                        >
                            <option value="">Selecione</option>
                            @foreach ( App\Http\Enums\PackValidityEnum::cases() as $validity )
                                <option value="{{ $validity }}">{{ $validity }}</option>
                            @endforeach
                        </x-form.select>

                        <x-form.error :messages="$errors->get('validity')" />
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="description"
                            :value="__('Descrição')"
                        />

                        <x-form.textarea
                            id="description"
                            name="description"
                            type="text"
                            class="block w-full"
                            :value="old('description')"
                            autofocus
                            autocomplete="description"
                        ></x-form.textarea>

                        <x-form.error :messages="$errors->get('description')" />
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
