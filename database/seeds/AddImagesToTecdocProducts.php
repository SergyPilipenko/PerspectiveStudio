<?php

use App\Models\Admin\Catalog\Product\Product;
use App\Models\Admin\Catalog\Product\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddImagesToTecdocProducts extends Seeder
{
    private $productImage;

    /**
     * AddImagesToTecdocProducts constructor.
     * @param ProductImage $productImage
     */
    public function __construct(ProductImage $productImage)
    {

        $this->productImage = $productImage;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $this->productImage->where('type', 'tecdoc')->delete();

        $sql = "
        SELECT tai.PictureName, pp.id as product_id, tai.supplierid FROM ".env('DB_DATABASE').".products pp
        JOIN ".env('DB_TECDOC_DATABASE').".article_numbers tan ON pp.id = tan.id
        JOIN ".env('DB_TECDOC_DATABASE').".article_images tai ON tan.supplierid = tai.supplierid AND tan.datasupplierarticlenumber = tai.DataSupplierArticleNumber
        ";

        $images = DB::connection('mysql_tecdoc')->select($sql);
        $productImages = [];
        if(count($images)) {
            foreach ($images as $image) {
                if(File::exists(public_path().'/'.env('TECDOC_IMAGES_PATH').'/'.$image->supplierid.'/'.$image->PictureName)) {
                    $productImages[] = [
                        'type' => 'tecdoc',
                        'path' => env('TECDOC_IMAGES_PATH').'/'.$image->supplierid.'/'.$image->PictureName,
                        'product_id' => $image->product_id,
                        'name' => $image->PictureName
                    ];
                }
            }
        }

        echo count($productImages) . " images found\n";
        if(count($productImages)) {
            $this->productImage->insert($productImages);
        }

//        if($tecdocProducts->count()) {
//            foreach ($tecdocProducts as $product) {
//
//            }
//        }
    }
}
