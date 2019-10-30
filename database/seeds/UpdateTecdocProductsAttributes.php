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
    private $customAattributes;
    private $total = 0;
    private $iteration = 0;
    private $partCount = 200;

    public function __construct(AttributeFamily $attributeFamily, ProductAttributeValue $productAttributeValue, ProductImage $productImage)
    {
        $this->attributeFamily = $attributeFamily->where('code', 'tecdoc')->firstOrFail();
        $this->productAttributeValue = $productAttributeValue;
        $this->productImage = $productImage;
        $this->tecdoc_attribute_family_id = AttributeFamily::where('code', 'tecdoc')->first()->id;

    }

    public function deleteOldAttributes()
    {
        DB::table(env('DB_DATABASE').".product_attribute_values as pv")
            ->join(env('DB_DATABASE').".products as p", "pv.product_id","p.id")
            ->where("attribute_family_id", $this->tecdoc_attribute_family_id)
            ->delete();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($last_id = false)
    {

//        $products = DB::table(env('DB_DATABASE').".products as pp")
//            ->select("pp.id", "ta.NormalizedDescription as name", "ts.description as manufacturer", "tan.supplierId as supplierId")
//            ->join(env('DB_TECDOC_DATABASE').".article_numbers as tan", "pp.id", "tan.id")
//            ->join(env('DB_TECDOC_DATABASE').".articles as ta", function ($join) {
//                $join->on("tan.datasupplierarticlenumber", "ta.DataSupplierArticleNumber")
//                    ->on("tan.supplierId", "ta.supplierId");
//            })
//            ->join(env('DB_TECDOC_DATABASE').".suppliers as ts", "tan.supplierId", "ts.id")
//            ->where("pp.attribute_family_id", $this->tecdoc_attribute_family_id)
//            ->orderBy('id')
//            ->chunk(1000, function ($products) {
//                if(!$this->customAattributes) {
//                    $this->customAattributes = $this->attributeFamily->custom_attributes()->get();
//                }
//
//                $productAttributes = [];
//                foreach ($products as $key => $product) {
//                    foreach ($this->customAattributes as $attrkey => $customAattribute)
//                    {
//                        $attr = [];
//                        foreach ($this->productAttributeValue->getFillableFields() as $fillableField) {
//                            $attr[$fillableField] = null;
//                        }
//                        $attr['product_id'] = $product->id;
//                        $attr['attribute_id'] = $customAattribute->id;
//                        if($customAattribute->code == 'slug') {
//                            $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = Transliterate::slugify($product->name) . "-{$product->id}" ;
//                        }
//                        if($customAattribute->code == 'status') {
//                            $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 1;
//                        }
//                        if($customAattribute->code == 'isNew') {
//                            $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 1;
//                        }
//                        if($customAattribute->code == 'price') {
//                            $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 0;
//                        }
//                        if($customAattribute->code == 'short_description' || $customAattribute->code == 'name' || $customAattribute->code == 'description') {
//                            $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = $product->name;
//                        }
//                        $productAttributes[] = $attr;
//                    }
//                }
//                foreach (array_chunk($productAttributes,1000) as $t) {
//                    $this->productAttributeValue->insert($t);
//                }
//        });
        if(!$this->total) {
            $this->deleteOldAttributes();
            $this->total = DB::connection('mysql')->selectOne("SELECT count(*) as total FROM products")->total;
        }

        $sql = "SELECT pp.id, ta.NormalizedDescription as name, ts.description as manufacturer, tan.supplierId as supplierId
                FROM ".env('DB_DATABASE').".products pp
                JOIN ".env('DB_TECDOC_DATABASE').".article_numbers tan ON pp.id = tan.id
                JOIN ".env('DB_TECDOC_DATABASE').".articles ta ON tan.datasupplierarticlenumber = ta.DataSupplierArticleNumber AND tan.supplierId = ta.supplierId
                JOIN ".env('DB_TECDOC_DATABASE').".suppliers ts ON tan.supplierId = ts.id
                WHERE pp.attribute_family_id = ".$this->tecdoc_attribute_family_id."
                ";
        if($last_id) {
            $sql .= " AND pp.id > $last_id";
        }
        $sql .= " LIMIT {$this->partCount}";
//        dd($sql);

        $products = DB::connection('mysql')->select($sql);
//        dd($products);
        if(!count($products)) {
            echo "done";
            return;
        };

        if(!$this->customAattributes) {
            $this->customAattributes = $this->attributeFamily->custom_attributes()->get();
        }

        $productAttributes = [];
        foreach ($products as $key => $product) {
            foreach ($this->customAattributes as $attrkey => $customAattribute)
            {
                $attr = [];
                foreach ($this->productAttributeValue->getFillableFields() as $fillableField) {
                    $attr[$fillableField] = null;
                }
                $attr['product_id'] = $product->id;
                $attr['attribute_id'] = $customAattribute->id;
                if($customAattribute->code == 'slug') {
                    $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = Transliterate::slugify($product->name) . "-{$product->id}" ;
                }
                if($customAattribute->code == 'status') {
                    $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 1;
                }
                if($customAattribute->code == 'isNew') {
                    $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 1;
                }
                if($customAattribute->code == 'price') {
                    $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = 0;
                }
                if($customAattribute->code == 'manufacturer') {
                    $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = $product->manufacturer;
                }
                if($customAattribute->code == 'short_description' || $customAattribute->code == 'name' || $customAattribute->code == 'description') {
                    $attr[ProductAttributeValue::$attributeTypeFields[$customAattribute->type]] = $product->name;
                }
                $productAttributes[] = $attr;
            }
            $this->last_id = $product->id;
        }
        $this->productAttributeValue->insert($productAttributes);
        $this->iteration += count($products);
        echo $this->iteration.'/'.$this->total."\n";
        $this->run($this->last_id);
//        foreach (array_chunk($productAttributes,1000) as $t) {
//            $this->productAttributeValue->insert($t);
//        }
//        $sql = "SELECT pp.id, ta.NormalizedDescription as name, ts.description as manufacturer, tan.supplierId as supplierId
//                FROM ".env('DB_DATABASE').".products pp
//                JOIN ".env('DB_TECDOC_DATABASE').".article_numbers tan ON pp.id = tan.id
//                JOIN ".env('DB_TECDOC_DATABASE').".articles ta ON tan.datasupplierarticlenumber = ta.DataSupplierArticleNumber AND tan.supplierId = ta.supplierId
//                JOIN ".env('DB_TECDOC_DATABASE').".suppliers ts ON tan.supplierId = ts.id
//                WHERE pp.attribute_family_id = ".$this->tecdoc_attribute_family_id."
//                ";
//        if($id_from) {
//            $sql .= " AND pp.id > {$id_from}";
//        }
//        $sql .= " LIMIT 500";
//
//        $products = DB::connection('mysql')->select($sql);
//        $this->iteration += count($products);
//        if(!count($products)) {
//
//            dd("done");
//        }
//
//        $product_images = [];
//        foreach ($products as $key => $product) {
//            dd($product);
//            foreach ($attributes as $attrkey => $attribute) {
//                $this->productAttributesData[$key][$attrkey]['product_id'] = $product->id;
//                $this->productAttributesData[$key][$attrkey]['attribute_id'] = $attribute->id;
//                $attr_code = $attribute->code;
//
//                if(isset($product->$attr_code)) {
//                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = $product->$attr_code;
//                }
//                if($attribute->code == 'slug') {
//                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = Transliterate::slugify($product->name) . "-{$product->id}" ;
//                }
//                if($attribute->code == 'description') {
//                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = $product->name;
//                }
//                if($attribute->code == 'status') {
//                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = 1;
//                }
//                if($attribute->code == 'isNew') {
//                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = 1;
//                }
//                if($attribute->code == 'price') {
//                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = 0;
//                }
//                if($attribute->code == 'short_description') {
//                    $this->productAttributesData[$key][$attrkey][ProductAttributeValue::$attributeTypeFields[$attribute->type]] = $product->name;
//                }
//            }
////            $product_images[] = [
////                'type' => 'tecdoc',
////                'path' => env('TECDOC_IMAGES_PATH').'/'.$product->supplierId.'/'.$product->PictureName,
////                'name' => env('TECDOC_IMAGES_PATH').'/'.$product->supplierId.'/'.$product->PictureName,
////                'product_id' => $product->id
////            ];
//            $this->last_id = $product->id;
//        }
//
//        foreach ($this->productAttributesData as $data) {
//            foreach ($data as $item) {
//                $this->productAttributeValue->insert($item);
//            }
//        }
//        echo $this->iteration.'/'.$this->total."\n";
//        $this->run($this->last_id);
////        $this->productImage->insert($product_images);
//
//        dd('ok');
    }
}
