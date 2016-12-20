
<li>[{{$category->id}}] - {{$category->name}} </li>
@foreach($category->children as $child) 
    @if($loop->first)
        <ul>   
    @endif
    @include('category.category', ['category' => $child])  
    @if($loop->last)
        </ul>   
    @endif
@endforeach

