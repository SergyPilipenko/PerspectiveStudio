<?php

namespace App\Models\Admin\Import;

use Illuminate\Database\Eloquent\Model;

class InvalidPrice extends Model
{
    public function errors()
    {
        return $this->hasMany(InvalidPriceError::class);
    }

    public static function saveInvalidPrices(array $invalidPrices, ImportSetting $importSetting) : bool
    {
        $prices = [];

        foreach ($invalidPrices as $key => $invalidPrice) {
            $errors = $invalidPrice['errors'];
            $invalidPrice = $invalidPrice['row'];
            $new_invalid_price = new self();
            $new_invalid_price->article = $invalidPrice['article'];
            $new_invalid_price->supplier = $invalidPrice['supplier'];
            $new_invalid_price->price = (float) $invalidPrice['price'];
            $new_invalid_price->available = (int) $invalidPrice['available'];
            $new_invalid_price->import_setting_id = $importSetting->id;
            $new_invalid_price->save();
            $new_invalid_price->saveInvalidPriceErrors($errors);
        }
        return true;
    }

    protected function saveInvalidPriceErrors(array $errors) : bool
    {
        $new_errors = [];
        foreach ($errors as $key => $error) {
            $new_errors[$key]['invalid_price_id'] = $this->id;
            $new_errors[$key]['error'] = $error;
        }
        return InvalidPriceError::insert($new_errors);
    }
}
