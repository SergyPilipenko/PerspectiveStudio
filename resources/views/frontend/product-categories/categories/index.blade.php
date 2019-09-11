<ul>
    @foreach($categories as $category)
        <li>
            <a href="{{ route('frontend.product-categories.show', $category->slug) }}">{{ $category->category_title }}</a>
        </li>
    @endforeach
</ul>
