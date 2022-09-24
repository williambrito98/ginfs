@props(['routeAdd', 'routeDelete', 'userID'])

<div class="flex flex-end flex-row-reverse">
    <div>
        <x-add-register :route="$routeAdd" />
    </div>
    <div>
        <x-delete-register :route="$routeDelete"/>
    </div>
</div>