<button type="submit" name="{{$function}}" {{$attributes->merge(['class'=>'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 text-xs '.$cssClass])}}
    @if($isWired)
        wire:click.prevent="{{$function}}"
    @endif
>
    {{$slot}}
</button>
