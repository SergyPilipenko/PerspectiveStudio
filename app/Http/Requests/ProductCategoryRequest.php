<?php

namespace App\Http\Requests;

use App\Http\Requests\RequestInterface;
use App\Models\Catalog\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class ProductCategoryRequest extends FormRequest implements RequestInterface
{
    private $rules;
    /**
     * @var Category
     */
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;

    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $loc = app()->getLocale();

        $category = $this->category->findOrFail($this->id);

        $this->rules = [
            $loc . '.category_title' => 'required|max:255|min:2',
            $loc . '.slug' => 'required|max:255|min:2|unique:catalog_categories,slug,'.$category->id,
        ];

        return $this->rules;
    }
}
