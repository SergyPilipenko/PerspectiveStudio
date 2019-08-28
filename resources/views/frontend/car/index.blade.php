@extends('frontend')

@section('content')
    <div class="container">
        <garage
            :garage="'{{ $garage }}'"
            :current_auto="'{{ json_encode($current_auto) }}'"
        ></garage>
        @if($categories->count())
            <ul>
                @foreach($categories as $category)
                    <li>
                        <a href="{{ route('frontend.category', [$brand, $model, $modification, $category->slug]) }}">{{ $category->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            @if(count($parts))
                <ul>
                    @foreach($parts as $part)
                        <li>
                            <a href="">
                                {{ $part->supplier_name }} {{ $part->product_name }} {{ $part->part_number }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                @else            
                <h1>Category is empty</h1>
            @endif
        @endif
    </div>
@endsection
