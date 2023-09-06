@props([
    'disabled' => false,
    'name' => null,
    'value' => null,
])

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
            'class' => 'block w-full py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring
            focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1
            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1',
        ])
    !!}
    id="{{ $name }}"
    name="{{ $name }}"
    type="text"
    required
    autofocus
    autocomplete="{{ $name }}"
>
    <option value="1" {{ $value ? 'selected' : false }}>Ativo</option>
    <option value="0" {{ !$value ? 'selected' : false }}>Inativo</option>
</select>
