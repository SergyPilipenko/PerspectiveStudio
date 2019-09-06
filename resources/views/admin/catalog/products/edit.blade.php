@extends('admin')
@section('content')
    <div class="card">
        <form action="{{ route('admin.catalog.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="card-body">
                <div class="row card-control-header">
                    <div class="col-md-10">
                        <h3>Новый товар</h3>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success float-right">Сохранить</button>
                    </div>
                </div>
                <div class="v-cloak--hidden">
                    @foreach($product->attribute_family->attribute_groups as $attribute_group)
                        @if($attribute_group->group_attributes->count())
                            <accordian>
                                <div slot="header">{{ $attribute_group->name }}</div>
                                <div slot="body">
                                    @foreach($attribute_group->group_attributes as $attribute)
                                        @include('admin.catalog.products.field-types.' . $attribute->type, ['attribute' => $attribute, 'product' => $product])
{{--                                        @if($type_view = view()->exists('admin.catalog.products.field-types' . $attribute->type))--}}
{{--                                            --}}
{{--                                            @include($type_view, $attribute)--}}
{{--                                        @endif--}}
                                    @endforeach
                                </div>
                            </accordian>
                        @endif
                    @endforeach
                    @include('admin.catalog.products.accordians.images', ['product' => $product])
                </div>
            </div>
        </form>
    </div>
@endsection
