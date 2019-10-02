@foreach($navCategories = App\Models\Catalog\Category::active()->orderBy('parent_id', 'asc')->get() as $key => $category)
    @if($key <= 7)
        <li>
            <a href="{{ route('frontend.product-categories.show', $category->slug) }}">
                {{ $category->category_title }}
            </a>
        </li>
    @endif
@endforeach
