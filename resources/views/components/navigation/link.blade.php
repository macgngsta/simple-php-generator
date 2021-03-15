@if($isActive)
    <a href="{{url($link)}}" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">{{$title}}</a>
@else
    <a href="{{url($link)}}"  class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{{$title}}</a>
@endif
