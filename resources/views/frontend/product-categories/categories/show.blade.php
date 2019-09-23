<div>
    <img style="max-width: 100px" src="{{ asset($category->image) }}" alt="">
</div>
<h1>{{ $category->category_title }}</h1>
@if(isset($category->children) && $category->children->count())
    <ul>
        @foreach($category->children as $category_child)
            <li>
                <a href="{{ route('frontend.product-categories.show', $category_child->slug) }}">
                    <div>
                        <img style="max-width: 100px" src="{{ asset($category->image) }}" alt="">
                    </div>
                    <div>
                        {{ $category_child->category_title }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@endif
<h2>Товары</h2>
@if(isset($category->products) && $category->products->count())
    <ul>
        @foreach($category->products as $product)
            @if($productSlug = $product->getAttrValue('slug'))
                <li>
                    <a href="{{ route('frontend.product.show', $productSlug) }}">{{ $product->getAttrValue('name') }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endif

