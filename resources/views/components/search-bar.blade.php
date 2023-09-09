<div class="max-w-10xl sm:px-6 lg:px-8">
    <div class="flex justify-between">
        <form method="GET" class="flex gap-3">
            <x-form.input id="search" name="search" type="text" class="block w-full" :value="request()->search" placeholder="Pesquisar"
                autofocus />
            <x-button>
                <i class="fas fa-search"></i>
            </x-button>
        </form>
    </div>
</div>
