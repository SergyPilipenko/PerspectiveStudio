<ul>
    @foreach($categories as $category)
        <li>
            <a href="{{ route('frontend.product-categories.show', $category->slug) }}">
                <div>
                    <img style="max-width: 100px" src="{{ asset($category->image) }}" alt="">
                </div>
                <div>
                    {{ $category->category_title }}
                </div>
            </a>
        </li>
    @endforeach
</ul>
