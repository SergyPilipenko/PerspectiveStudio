<?php

use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Product\ProductAttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Catalog\Product\ProductImage;

class UpdateTecdocProductsAttributes extends Seeder
{
    private $attributeFamily;
    private $productAttributeValue;
    private $productAttributesData = [];
    private $productImage;
    private $last_id;
    private $tecdoc_attribute_family_id;
    private $total;
    private $iteration = 0;

    public function __construct(AttributeFamily $attributeFamily, ProductAttributeValue $productAttributeValue, ProductImage $productImage)
    {
        $this->attributeFamily = $attributeFamily->where('code', 'tecdoc')->firstOrFail();
        $this->productAttributeValue = $productAttributeValue;
        $this->productImage = $productImage;
        $this->tecdoc_attribute_family_id = AttributeFamily::where('code', 'tecdoc')->first()->id;

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($id_from = false)
    {
        if(!$this->total) {
            $this->total = \App\Models\Admin\Catalog\Product\Product::all()->count();
        }
        $sql = "SELECT pp.id, ta.NormalizedDescription as name, ts.description as manufacturer, tan.supplierId as supplierId
                FROM ".env('DB_DATABASE').".products pp
                JOIN ".env('DB_TECDOC_DATABASE').".article_numbers tan ON pp.id = tan.id
                JOIN ".env('DB_TECDOC_DATABASE').".articles ta ON tan.datasupplierarticlenumber = ta.DataSupplierArticleNumber AND tan.supplierId = ta.supplierId
                JOIN ".env('DB_TECDOC_DATABASE').".suppliers ts ON tan.supplierId = ts.id
                WHERE pp.attribute_family_id = ".$this->tecdoc_attribute_family_id."
                ";
        if($id_from) {
            $sql .= " AND pp.id > {$id_from}";
        }
        $sql .= " LIMIT 500";

        $products = DB::connection('mysql')->select($sql);
        $this->iteration += count($products);
        if(!count($products)) {

            dd("done");
        }
        $attributes = $this->attributeFamily->custom_attributes()->get();

        $product_images = [];
        foreach ($products as $key => $product) {
            foreach ($attributes as $attrkey => $attribute) {
                $this->productAttributesData[$key][$attrkey]['product_id'] = $product->id;
                $this->productAttributesData[$key][$attrkey]['attribute_id'] = $attribute->id;
                $attr_code = $attribute->code;

                if(isset($product->$attr_code)) {
                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = $product->$attr_code;
                }
                if($attribute->code == 'slug') {
                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = Transliterate::slugify($product->name) . "-{$product->id}" ;
                }
                if($attribute->code == 'description') {
                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = $product->name;
                }
                if($attribute->code == 'status') {
                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = 1;
                }
                if($attribute->code == 'isNew') {
                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = 1;
                }
                if($attribute->code == 'price') {
                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = 0;
                }
                if($attribute->code == 'short_description') {
                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = $product->name;
                }
            }
//            $product_images[] = [
//                'type' => 'tecdoc',
//                'path' => env('TECDOC_IMAGES_PATH').'/'.$product->supplierId.'/'.$product->PictureName,
//                'name' => env('TECDOC_IMAGES_PATH').'/'.$product->supplierId.'/'.$product->PictureName,
//                'product_id' => $product->id
//            ];
            $this->last_id = $product->id;
        }

        foreach ($this->productAttributesData as $data) {
            foreach ($data as $item) {
                $this->productAttributeValue->insert($item);
            }
        }
        echo $this->iteration.'/'.$this->total."\n";
        $this->run($this->last_id);
//        $this->productImage->insert($product_images);

        dd('ok');
    }
}
