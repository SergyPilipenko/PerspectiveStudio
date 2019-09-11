<?php


namespace App\Traits;
use App\Exceptions\AttributeIsNotTranslatable;
use App\Http\Requests\RequestInterface;

trait HasTranslations
{
    use \Spatie\Translatable\HasTranslations;

    public function setCategoryTranslations(RequestInterface $request)
    {
        $loc = app()->getLocale();

        if(isset($request->$loc) && count($request->$loc)) {
            foreach ($request->$loc as $key => $item) {
                if(in_array($key, $this->getTranslatableAttributes())) {
                    $this->setTranslation($key, $loc, $request->$loc[$key]);
                } else {
                    throw AttributeIsNotTranslatable::make($key, $this);
                }
            }
        }
    }
}
