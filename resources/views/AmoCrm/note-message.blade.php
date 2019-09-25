Почта: {{ $order->customer_email }}
Телефон: {{ $order->customer_phone }}
Имя: {{ $order->customer_first_name }}
Фамилия: {{ $order->customer_last_name }}
Заказ на сумму: {{ $order->grand_total }}
@if($order->order_comment)
    <br />
    Комментарий к заказу: "{{ $order->order_comment }}"
@endif
<hr>
Всего товаров: {{ $order->total_item_count }}
Всего единиц товаров: {{ $order->total_qty_ordered }}
<hr>
Товары:
@foreach($order->orderItems as $orderItem)
    Артикул: {{ $orderItem['article'] }}
    Название: {{ $orderItem['name'] }}
    Ссылка на товар: {{ route('frontend.product.show', App\Models\Admin\Catalog\Product\Product::find($orderItem['product_id'])->getAttrValue('slug')) }}
    Количество: {{ $orderItem['qty_ordered'] }}
    Цена за единицу: {{ $orderItem['price'] }}
    Общая цена товара: {{ $orderItem['total'] }}
    <br />
@endforeach
