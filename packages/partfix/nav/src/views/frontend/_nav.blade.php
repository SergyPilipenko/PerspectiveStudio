@foreach($navCategories = app('Partfix\Nav\App\NavInterface')->getNav() as $key => $category)
    @if($key <= 7)
        <li>
            <a href="{{ route('frontend.product-categories.show', $category->slug) }}">
                {{ $category->category_title ?? $category->title }}
            </a>
        </li>
    @endif
@endforeach
