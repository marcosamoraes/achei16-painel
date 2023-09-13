<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Cadastrar contrato
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <form
                method="post"
                action="{{ route('contracts.store') }}"
            >
                @csrf

                <div class="mb-5 grid grid-cols-1 gap-y-6 gap-x-4">
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
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <x-form.error :messages="$errors->get('name')" />
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-y-6 gap-x-4">
                    <div class="space-y-2">
                        <x-form.label
                            for="description"
                            :value="__('Descrição')"
                        />

                        <div id="editor" style="height: 300px">
                            {!! old('description') !!}
                        </div>
                        <input type="hidden" id="description" name="description">

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

<script>
    var form = document.getElementById('contractForm');
    var descriptionInput = document.getElementById('description');
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        descriptionInput.value = quill.root.innerHTML;
        form.submit();
    });
</script>
