<li>
    <a class="{{ request()->route('id') && request()->route('id') == $category->id ? "badge badge-warning" : '' }}" href="{{ route('admin.catalog.categories.edit', $category->id) }}">{{ $category->category_title }}</a>
</li>
@if($category->children)
    <ul>
        @foreach($category->children as $child)
            @include('admin.catalog.categories.categoriesTree', ['category' => $child])
        @endforeach
    </ul>
@endif
