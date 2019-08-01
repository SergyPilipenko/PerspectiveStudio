<li>
    <a class="{{ request()->route('category') == $category->id ? "badge badge-warning" : '' }}" href="{{ route('admin.categories.edit', $category) }}">{{ $category->title }}</a>
</li>
@if($category->children)
    <ul>
        @foreach($category->children as $child)
            @include('admin.catalog.categories.categoriesTree', ['category' => $child])
        @endforeach
    </ul>
@endif
