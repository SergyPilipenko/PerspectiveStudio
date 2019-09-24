Почта: {{ $order->customer_email }}
Телефон: <a href="phone:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a>
Имя: <strong>{{ $order->customer_first_name }}</strong>
Фамилия: <strong>{{ $order->customer_last_name }}</strong>
Заказ на сумму: <strong>{{ $order->grand_total }}</strong>
@if($order->order_comment)
    <br />
    Комментарий к заказу: "{{ $order->order_comment }}"
@endif
<hr>
Всего товаров: {{ $order->total_item_count }}
Всего единиц товаров: {{ $order->total_qty_ordered }}
<hr>
<h3>Товары:</h3>
@foreach($order->orderItems as $orderItem)
    Артикул: {{ $orderItem['article'] }}
    Название: {{ $orderItem['name'] }}
    Ссылка на товар: {{ route('frontend.product.show', App\Models\Admin\Catalog\Product\Product::find($orderItem['product_id'])->getAttrValue('slug')) }}
    Количество: <strong>{{ $orderItem['qty_ordered'] }}</strong>
    Цена за единицу: {{ $orderItem['price'] }}
    Общая цена товара: {{ $orderItem['total'] }}
    <br />
@endforeach
