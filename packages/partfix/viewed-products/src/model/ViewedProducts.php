<?php


namespace Partfix\ViewedProducts\model;
use App\Models\Admin\Catalog\Product\ProductInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Session\SessionManager;
use Partfix\ViewedProducts\Contracts\ViewedProductsInterface;

class ViewedProducts implements ViewedProductsInterface
{
    private $sessionManager;
    private $productRepository;
    private $products;
    const VIEWED_PRODUCTS_SESSSION_KEY = 'viewedProducts';
    /**
     * @var ProductInterface
     */

    /**
     * ViewedProducts constructor.
     * @param SessionManager $sessionManager
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(SessionManager $sessionManager, ProductRepositoryInterface $productRepository)
    {
        $this->sessionManager = $sessionManager;
        $this->productRepository = $productRepository;
    }

    public function add(ProductInterface $product)
    {
        if(!in_array($product->id, $this->getViewedProductsIds())) {
            $this->addViewedProductId($product->id);
        }
    }

    public function getViewedProductsIds() : array
    {
        return $this->sessionManager->get(self::VIEWED_PRODUCTS_SESSSION_KEY) ?? [];
    }

    public function getViewedProducts()
    {
        if(!count($this->getViewedProductsIds())) return null;
        $ids = array_reverse($this->getViewedProductsIds());
        $this->products = $this->products ?? $this->productRepository->getProductsWithData($ids);

        return $this->products;
    }

    private function addViewedProductId($id) : void
    {
        $this->sessionManager->push(self::VIEWED_PRODUCTS_SESSSION_KEY, $id);
    }
}
