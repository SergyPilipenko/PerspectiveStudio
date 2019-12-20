@foreach($navCategories = app('Partfix\Nav\App\NavInterface')->getNav() as $key => $rubric)
    @if($key <= 7)
        <li>
            <a href="{{ route('frontend.rubric.index', $rubric->slug) }}">
                {{ $rubric->title }}
            </a>
        </li>
    @endif
@endforeach
