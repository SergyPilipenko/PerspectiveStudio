<?php


namespace App\Repositories\Product;


use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Product\ProductAttributeValue;
use App\Models\Admin\Catalog\Product\ProductInterface;
use Illuminate\Support\Facades\Cache;
use Partfix\QueryBuilder\Contracts\SQLQueryBuilder;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductInterface
     */
    private $product;
    /**
     * @var SQLQueryBuilder
     */
    private $queryBuilder;
    /**
     * @var AttributeFamily
     */
    private $attributeFamily;
    /**
     * @var ProductAttributeValue
     */
    private $productAttributeValue;
    private $customAattributes;
    private $productAttributes;
    private $attr;

    public function __construct(
        ProductInterface $product,
        SQLQueryBuilder $queryBuilder,
        AttributeFamily $attributeFamily,
        ProductAttributeValue $productAttributeValue
    )
    {
        $this->product = $product;
        $this->queryBuilder = $queryBuilder;
        $this->attributeFamily = $attributeFamily;
        $this->productAttributeValue = $productAttributeValue;
    }

    public function writeOffProductQuantity(array $orderItems)
    {
        foreach ($orderItems as $item) {
            $this->product->where('id', $item['product_id'])->decrement('quantity', $item['qty_ordered']);
        }
    }

    public function getProductsWithData($ids)
    {
        return  $this->product->whereIn('id', $ids)->with('productAttributeValues','images')->get();
    }

    public function createTecdocProducts($products)
    {
        $ids = $this->getImportProductsIds($products);

        $productsAreNotExists = $this->queryBuilder
            ->select(env('DB_TECDOC_DATABASE').'.article_numbers as an',
                ['distinct an.*', 'm.description as manufacturer', 'ta.NormalizedDescription as name'])
            ->leftJoin('products as p', 'an.id', 'p.id')
            ->join(env('DB_TECDOC_DATABASE').'.manufacturers as m', 'an.supplierid', 'm.id')
            ->multiJoin(env('DB_TECDOC_DATABASE').'.articles as ta', [
                'an.datasupplierarticlenumber' => 'ta.DataSupplierArticleNumber',
                'an.supplierId' => 'ta.supplierId'
            ])
            ->whereIn('an.id', $ids)
            ->where('p.id', '{NULL}', 'is');
        $newProducts = $productsAreNotExists->getResult();
        $attributeFamilyCode = 'tecdoc';
        $tecdocAttributeFamilyId = $this->getAttributeFamilyId($attributeFamilyCode);
        $data = [];
        foreach ($newProducts as $key => $product) {
            $data[$key]['id'] = $product->id;
            $data[$key]['article'] = $product->datasupplierarticlenumber;
            $data[$key]['type'] = $attributeFamilyCode;
            $data[$key]['attribute_family_id'] = $tecdocAttributeFamilyId;
            $product->price = $this->getImportPrice($products, $product->id);
        }

        $this->product->insert($data);
        $this->updateTecdocProductsAttributes($newProducts);
    }

    private function getImportProductsIds($products)
    {
        $ids = [];
        foreach ($products as $product) {
            $ids[] = $product['article_id'];
        }
        return $ids;
    }

    public function getAttributeFamilyId($code)
    {
        return $this->tecdoc_attribute_family_id = AttributeFamily::where('code', $code)->first()->id;
    }

    private function updateTecdocProductsAttributes($products)
    {
        $this->customAattributes = $this->attributeFamily->where('code', 'tecdoc')->firstOrFail()->custom_attributes()->get();

        $this->productAttributes = [];

        foreach ($products as $key => $product) {
            foreach ($this->customAattributes as $attrkey => $customAattribute)
            {
                $this->attr = [];
                foreach ($this->productAttributeValue->getFillableFields() as $fillableField) {
                    $this->attr[$fillableField] = null;
                }
                $this->attr['product_id'] = $product->id;
                $this->attr['attribute_id'] = $customAattribute->id;
                if($customAattribute->code == 'slug') {
                    $this->attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = \Transliterate::slugify($product->name) . "-{$product->id}" ;
                }
                if($customAattribute->code == 'status') {
                    $this->attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 1;
                }
                if($customAattribute->code == 'isNew') {
                    $this->attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 1;
                }
                if($customAattribute->code == 'price') {
                    $this->attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = $product->price;
                }
                if($customAattribute->code == 'manufacturer') {
                    $this->attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = $product->manufacturer;
                }
                if($customAattribute->code == 'short_description' || $customAattribute->code == 'name' || $customAattribute->code == 'description') {
                    $this->attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = $product->name;
                }
                $this->productAttributes[] = $this->attr;
            }
            $this->last_id = $product->id;
        }
        $this->productAttributeValue->insert($this->productAttributes);
    }

    public function getImportPrice($products, $id)
    {
        foreach ($products as $product) {
            if($product['article_id'] == $id) return $product['price'];
        }
    }
}
