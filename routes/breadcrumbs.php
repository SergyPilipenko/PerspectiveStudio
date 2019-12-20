<?php

Breadcrumbs::for('frontend.index', function ($trail) {
    $trail->push('Главная', route('frontend.index'));
});

Breadcrumbs::for('frontend.rubric.index', function ($trail, $rubric) {
    $trail->parent('frontend.index');
    $trail->push(ucfirst($rubric->title), route('frontend.rubric.index', $rubric->slug));
});

Breadcrumbs::for('frontend.product-categories.show', function ($trail, $category) {
    if($category->type != "tecdoc" && isset($category->parent)) {
        $trail->parent('frontend.product-categories.show', $category->parent);
    }else if($category->type == "tecdoc" && isset($category->parent->parent) ){
        $trail->parent('frontend.product-categories.show', $category->parent->parent);
    } else {
        $trail->parent('frontend.index');
    }
    $trail->push($category->category_title, route('frontend.product-categories.show', $category->slug));
});

Breadcrumbs::for('frontend.model', function ($trail, $brand, $model) {
    $trail->parent('frontend.index');
    $trail->push(ucfirst($brand)." $model", route('frontend.model', [$brand, $model]));
});

Breadcrumbs::for('frontend.product.show', function ($trail, $product) {
    $trail->parent('frontend.index');
    $category = $product->categories->first();
    if($category && $category->type != 'tecdoc') {
        $trail->push($category->category_title, route('frontend.product-categories.show', $category->slug));
    }
    $trail->push($product->custom_attributes['name'], route('frontend.product.show', $product->slug));
});

Breadcrumbs::for('frontend.modification', function ($trail, $car, $brand, $model, $modification) {
    $trail->parent('frontend.index');
    $trail->push("{$car->brand->description} {$car->model->description} {$car->year}", route('frontend.modification', [$brand, $model, $modification]));
});

Breadcrumbs::for('frontend.car.category', function ($trail, $category, $car, $brand, $model, $modification) {
    $trail->parent('frontend.modification', $car, $brand, $model, $modification);
    $trail->push("$category->category_title", route('frontend.car.category', [$brand, $model, $modification, $category->slug]));
});
