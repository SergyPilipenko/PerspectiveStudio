<h1>{{ $category->category_title }}</h1>
@if(isset($category->children) && $category->children->count())
    <ul>
        @foreach($category->children as $category_child)
            <li>
                <a href="{{ route('frontend.product-categories.show', $category_child->slug) }}">{{ $category_child->category_title }}</a>
            </li>
        @endforeach
    </ul>
@endif
<h2>Товары</h2>
@if(isset($category->products) && $category->products->count())
    <ul>
        @foreach($category->products as $product)
            <li>
                <a href="{{ route('frontend.product.show', $product->getAttrValue('slug')) }}">{{ $product->getAttrValue('name') }}</a>
            </li>
        @endforeach
    </ul>
@endif

