<button name="{{$function}}" type="button" {{$attributes->merge(['class'=>'inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-white font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 text-xs '.$cssClass])}}
    @if($isWired)
        wire:click.prevent="{{$function}}"
    @endif
>
    {{$slot}}
</button>
