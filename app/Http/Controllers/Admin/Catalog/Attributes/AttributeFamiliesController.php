<?php

namespace App\Http\Controllers\Admin\Catalog\Attributes;

use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Attributes\AttributeGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class AttributeFamiliesController extends Controller
{
    public function index(AttributeFamily $attributeFamily)
    {
        $attribute_families = $attributeFamily->get();

        return view('admin.catalog.attribute-families.index', compact('attribute_families'));
    }

    public function create(AttributeGroup $attributeGroup)
    {
        $groups = $attributeGroup->default()->with('attributes')->get();
        $custom_attributes = Attribute::custom()->get();

        return view('admin.catalog.attribute-families.create', compact('groups','custom_attributes'));
    }

    public function store(Request $request, AttributeFamily $attributeFamily)
    {
        $this->validate($request, array(
            'name' => 'required',
            'code' => 'required|unique:attribute_families,code',
            'groups' => 'required'
        ));

        try {
            DB::connection()->getPdo()->beginTransaction();

            $attributeFamily->name = $request->name;
            $attributeFamily->code = $request->code;
            $attributeFamily->save();
            $attributeFamily->updateFamilyGroups($request->groups);

            Session::flash('flash', 'Набор атрибутов был создан успешно');

            DB::connection()->getPdo()->commit();

            return redirect()->back();

        } catch (\PDOException $e) {
            dd($e);
            DB::connection()->getPdo()->rollBack();
        }
    }

    public function edit($id, AttributeFamily $attributeFamily)
    {
        $attributeFamily = $attributeFamily->whereId($id)->with('attribute_groups.attributes')->firstOrFail();
        $groups = $attributeFamily->attribute_groups;
        $custom_attributes = $this->getAvailableAttributesInAttributeFamily($attributeFamily);
        $new_collection = [];
        foreach ($custom_attributes as $custom_attribute) {
            $new_collection[] = $custom_attribute;
        }
        $custom_attributes = collect($new_collection);

        return view('admin.catalog.attribute-families.edit', compact('attributeFamily', 'custom_attributes', 'groups'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, array(
            'name' => 'required',
            'groups' => 'required'
        ));

        $attributeFamily =  AttributeFamily::whereId($id)->with('attribute_groups')->firstOrFail();


        try {
            DB::connection()->getPdo()->beginTransaction();

            $attributeFamily->name = $request->name;

            $attributeFamily->update();

            $attributeFamily->updateFamilyGroups($request->groups);

            Session::flash('flash', 'Набор атрибутов был создан успешно');

            DB::connection()->getPdo()->commit();

            return redirect()->back();

        } catch (\PDOException $e) {
            dd($e);
            DB::connection()->getPdo()->rollBack();
        }

    }

    public function destroy(AttributeFamily $attributeFamily)
    {

        try {

            $attributeFamily->delete();

        } catch (QueryException $exception) {

            Session::flash('flash', 'Этот набор аттрибутов используется в товарах');

            return redirect()->back();
        }

        Session::flash('flash', 'Набор атрибутов был удален создан успешно');

        return redirect()->back();
    }

    /**
     * @param AttributeFamily $attributeFamily
     * @param $custom_attributes
     */
    protected function getAvailableAttributesInAttributeFamily(AttributeFamily $attributeFamily) : Collection
    {
        $custom_attributes = Attribute::custom()->get();

        foreach ($attributeFamily->attribute_groups as $attribute_group) {
            foreach ($attribute_group->attributes as $attribute) {
                if ($custom_attributes->contains('id', $attribute->id)) {
                    foreach ($custom_attributes as $key => $custom_attribute) {
                        if ($custom_attribute->id == $attribute->id) {
                            $custom_attributes->forget($key);
                        }
                    }

                }
            }
        }

        return $custom_attributes;
    }
}
