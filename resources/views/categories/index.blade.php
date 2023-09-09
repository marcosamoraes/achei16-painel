<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            Categorias
        </h2>
        <a href="{{ route('categories.create') }}"><x-button>Cadastrar</x-button></a>
    </x-slot>

    <x-search-bar />

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
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Nome</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 dark:bg-dark-eval-1 text-center">
                                    <span class="text-xs leading-4 font-medium text-gray-500 dark:text-white uppercase tracking-wider">Status</span>
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
                            @foreach($categories as $category)
                                <tr class="bg-white dark:bg-dark-eval-1">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $category->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm text-center leading-5 text-gray-900 dark:text-white">
                                        @if ($category->status)
                                            <span class="text-green-500">Ativo</span>
                                        @else
                                            <span class="text-red-500">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white">
                                        {{ $category->created_at?->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 dark:text-white flex gap-3">
                                        <a href="{{ route('categories.edit', $category->id) }}">
                                            <x-button variant="warning">
                                                <i class="fas fa-edit"></i>
                                            </x-button>
                                        </a>
                                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button variant="danger" onclick="if (!confirm('Você tem certeza que quer deletar?')) return false">
                                                <i class="fas fa-trash"></i>
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
