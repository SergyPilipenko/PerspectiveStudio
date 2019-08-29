<li>
    <a class="{{ request()->route('category') == $category->id ? "badge badge-warning" : '' }}" href="{{ route('admin.tecdoc.categories.edit', $category->id) }}">{{ $category->title }}</a>
</li>
@if($category->children)
    <ul>
        @foreach($category->children as $child)
            @include('admin.tecdoc.categories.categoriesTree', ['category' => $child])
        @endforeach
    </ul>
@endif
