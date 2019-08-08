<div class="col-md-2">
    <div class="categories_sidebar">
        <div class="top-buttons">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm grid-margin">Добавить корневую категорию</a>
            @if(isset($category))
                <a href="{{ route('admin.categories.create-subcategory', $category->id) }}" class="btn btn-secondary btn-sm">Добавить дочернюю категорию</a>
            @endif
        </div>
        <div class="categories_tree">
            <ul>
                @foreach($categories as $category)
                    @include('admin.catalog.categories.categoriesTree', ['category' => $category])
                @endforeach
            </ul>
        </div>
    </div>
</div>
