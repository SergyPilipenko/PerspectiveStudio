<?php

use App\Models\Admin\Catalog\Product\Product;
use App\Models\Admin\Catalog\Product\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AddImagesToTecdocProducts extends Seeder
{
    private $productImage;
    const LIMIT = 10000;
    private $offset = 0;
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
        if(!$this->offset) $this->productImage->where('type', 'tecdoc')->delete();
        $sql = "
        SELECT tai.PictureName, pp.id as product_id, tai.supplierid FROM ".env('DB_DATABASE').".products pp
        JOIN ".env('DB_TECDOC_DATABASE').".article_numbers tan ON pp.id = tan.id
        JOIN ".env('DB_TECDOC_DATABASE').".article_images tai ON tan.supplierid = tai.supplierid AND tan.datasupplierarticlenumber = tai.DataSupplierArticleNumber
        LIMIT ".self::LIMIT." OFFSET {$this->offset}
        ";

        $images = DB::connection('mysql_tecdoc')->select($sql);
        $productImages = [];
        if(count($images)) {
            foreach ($images as $image) {
                $image->PictureName = preg_replace_callback('/\.\w+$/', function($m){
                    return strtolower('.jpg');
                }, $image->PictureName);

                if(File::exists(public_path().'/'.env('TECDOC_IMAGES_PATH').'/'.$image->supplierid.'/'.$image->PictureName)) {
                    echo public_path().'/'.env('TECDOC_IMAGES_PATH').'/'.$image->supplierid.'/'.$image->PictureName."\n";
                    $productImages[] = [
                        'type' => 'tecdoc',
                        'path' => env('TECDOC_IMAGES_PATH').'/'.$image->supplierid.'/'.$image->PictureName,
                        'product_id' => $image->product_id,
                        'name' => $image->PictureName
                    ];
                } else {
                    Log::debug(public_path().'/'.env('TECDOC_IMAGES_PATH').'/'.$image->supplierid.'/'.$image->PictureName."\n");
                }
            }
            $this->offset += self::LIMIT;
            $this->productImage->insert($productImages);
            $this->run();
        }

//        echo count($productImages) . " images found\n";
//        if(count($productImages)) {
//
//        }

//        if($tecdocProducts->count()) {
//            foreach ($tecdocProducts as $product) {
//
//            }
//        }
    }
}
