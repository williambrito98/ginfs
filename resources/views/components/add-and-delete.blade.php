@props(['routeAdd', 'routeDelete', 'userID'])

<div class="flex flex-end flex-row-reverse mb-3.5">
    <div>
        <x-add-register :route="$routeAdd" />
    </div>
    <div>
        <x-delete-register :route="$routeDelete"/>
    </div>
</div>