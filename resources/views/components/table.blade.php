@props(['columns', 'content'])
<table {{$attributes->merge(['class' => 'bg-table border-collapse clear-both text-center w-full'])}}>
    <thead>
        {{ $columns }}
    </thead>
    <tbody>
        {{ $content }}
    </tbody>
</table>