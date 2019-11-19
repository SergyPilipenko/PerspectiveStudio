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
        return $category->builder->select('article_links as al ', ['an.id'])
            ->join('passanger_car_pds as pds', 'al.supplierid', 'pds.supplierid')
            ->multiJoin('article_numbers as an', [
                'prd.id' => 'al.productid',
                'al.supplierid' => 'an.supplierid'
            ])
            ->join('passanger_car_prd as prd', 'prd.id', 'al.productid')
            ->where('al.productid', 'pds.productid')
            ->where('al.linkageid', 'pds.passangercarid')
            ->where('al.linkageid', 26912)
            ->whereIn("pds.nodeid", function ($query) {
                return $query->select("distinct_passanger_car_trees", ["passanger_car_trees_id"])
                    ->where('_lft', 1, '>=')
                    ->where('_rgt', 10, '<=');
            })
            ->where('al.linkagetypeid', 2);
    }

    public function getCategoryProductsQty(CategoryInterface $category, $modification = null)
    {
        $builder = $category->newProducts();
        $query = $this->product->newFilter($builder, $category->filterableAttributes);
        if($modification) {
            $builder->join('tecdoc2018_db.passanger_car_pds as pds', 'art.productId', 'pds.productId')->where('pds.passangercarid', $modification);
        }
        $cache = Cache::get(md5($query->getQuery()));
        if(!$cache) {
            $result = $query->getArrayResult();
//            Cache::put(md5($query->getQuery()), $result, now()->addMinutes(1));
        } else {
            $result = $cache;
        }

        return count($result);
    }

    public function getCategoryProductsIds(CategoryInterface $category)
    {
        $builder = $category->newProducts();
        $query = $this->product->newFilter($builder, $category->filterableAttributes);
        $cache = Cache::get(md5($query->getQuery()));
        if(!$cache) {
            $result = $query->getArrayResult();
//            Cache::put(md5($query->getQuery()), $result, now()->addMinutes(1));
        } else {
            $result = $cache;
        }

        return array_column($result, 'id');
    }
}
