<?php


namespace App\Repositories\Product;


use App\Models\Admin\Catalog\Product\ProductInterface;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductInterface
     */
    private $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function writeOffProductQuantity(array $orderItems)
    {
        foreach ($orderItems as $item) {
            $this->product->where('id', $item['product_id'])->decrement('quantity', $item['qty_ordered']);
        }
    }

    public function getProductsWithData($ids)
    {
        return  $this->product->whereIn('id', $ids)->with('productAttributeValues')->get();
    }
}
