<?php


namespace App\Repositories\CatalogCategory;


use App\Models\Admin\Catalog\Product\Product;
use App\Models\Catalog\Category;
use App\Models\Catalog\CategoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Partfix\Paginator\App\PaginatorInterface;

class CategoryRepository
{
    /**
     * @var Category
     */
    private $category;
    /**
     * @var Product
     */
    private $product;
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(Product $product, PaginatorInterface $paginator, ProductRepositoryInterface $productRepository)
    {
        $this->product = $product;
        $this->paginator = $paginator;
        $this->productRepository = $productRepository;
    }

    public function getCategoryProducts(CategoryInterface $category, $modification = null)
    {
        $builder = $category->newProducts();

//        if($modification) {
//            $builder->join('tecdoc2018_db.passanger_car_pds as pds', 'art.productId', 'pds.productId')->where('pds.passangercarid', $modification);
//        }

        $query = $this->product->newFilter($builder, $category->filterableAttributes);

//        $cache = Cache::get(md5($query->getQuery()));
        $cache = null;
        if(!$cache) {
            $result = $query->getArrayResult();
        } else {
            $result = $cache;
        }



        $products = $this->paginator->paginate($result, 20, request()->page);

        $ids = $products->getCollection()->pluck('id');

        $productsWithData = $this->productRepository->getProductsWithData($ids);

        $products->setCollection($productsWithData);

        return $products;
    }

    public function getCategoryProductsByModification($category, $modification)
    {
        $builder = $category->tecdocCategoryProductsByModification($modification);
        $query = $this->product->newFilter($builder, $category->filterableAttributes);
        $result = $query->getArrayResult();
        $products = $this->paginator->paginate($result, 20, request()->page);
        $ids = $products->getCollection()->pluck('id');
        $productsWithData = $this->productRepository->getProductsWithData($ids);
        $products->setCollection($productsWithData);

        return $products;
    }

    public function getCategoryProductsQty(CategoryInterface $category, $modification = null)
    {
        $builder = $modification ? $category->tecdocCategoryProductsByModification($modification) : $category->newProducts();

        $query = $this->product->newFilter($builder, $category->filterableAttributes);

        $result = $query->getArrayResult();

        return count($result);
    }

    public function getCategoryProductsIds(CategoryInterface $category)
    {
        $builder = $category->newProducts();
        $query = $this->product->newFilter($builder, $category->filterableAttributes);
        $cache = Cache::get(md5($query->getQuery()));
        if(!$cache) {
            $result = $query->getArrayResult();
        } else {
            $result = $cache;
        }

        return array_column($result, 'id');
    }
}
