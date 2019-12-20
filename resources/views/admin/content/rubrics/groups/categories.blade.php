<div class="form-check form-check-flat form-check-primary">
    <label class="form-check-label">
        <input type="checkbox" class="form-check-input" {{ $group->categories->contains('id', $category->id) ? 'checked' : '' }} name="categories[{{ $group->id }}][{{ $category->id }}]">
        {{ $category->category_title }}
        <i class="input-helper"></i>
    </label>
</div>
@if($category->children->count())
    <ul>
        @foreach($category->children as $child)
            @include('admin.content.rubrics.groups.categories', ['category' => $child])
        @endforeach
    </ul>
@endif
