<?php


namespace App\Classes\PriceFilter;


use App\Models\Admin\Catalog\Product\ProductInterface;

class PriceFilter implements PriceFilterInterface
{
    private $productTypePrice = [
        'tecdoc'
    ];

    public function getProductPrice(ProductInterface $product)
    {

        $price = null;
        foreach ($this->productTypePrice as $type)
        {
            if($type == $product->type)
            {
                $price = $this->$type($product);
            }
        }
        if(!$price) $price = $product->getDefaultPrice();

        return $price;
    }

    public function tecdoc(ProductInterface $product)
    {
        $tecdocPrices = $product->tecdocPrices;
        $minPrice = null;
        if($tecdocPrices->count())
        {
            foreach ($tecdocPrices as $tecdocPrice)
            {
                if(!isset($minPrice) || $minPrice > $tecdocPrice->price) $minPrice = $tecdocPrice->price;
            }
        }

        return $minPrice;
    }

}
