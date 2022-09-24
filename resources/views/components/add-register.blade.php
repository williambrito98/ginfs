@props(['route'])

<div class="flex justify-end items-center ml-8 mt-4 text-btns" id="addIcon">
    <div>
        <a href="{{ $route }}">NOVO
    </div>        
    <div class="ml-2">
        <x-svg.plusCircle />
    </div>
        </a>
</div>