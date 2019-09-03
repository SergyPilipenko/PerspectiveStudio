<?php

namespace App\Http\Controllers\Admin\Catalog\Attributes;

use App\Models\Admin\Catalog\Attributes\Attribute;
use App\Models\Admin\Catalog\Attributes\AttributeFamily;
use App\Models\Admin\Catalog\Attributes\AttributeGroup;
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
            foreach ($request->groups as $key => $group) {
                $group = json_decode($group,true);
                $attributeGroup = new AttributeGroup;
                $attributeGroup->name = $group['group']['name'];
                $attributeGroup->position = $group['group']['position'];
                $attributeGroup->attribute_family_id = $attributeFamily->id;
                $attributeGroup->save();

                $attributeGroup->attributes()->sync(array_column($group['attributes'], 'id'));

            }

            Session::flash('flash', 'Набор аттрибутов был создан успешно');

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

//        $custom_attributes = Attribute:;

//        dd($custom_attributes);



        return view('admin.catalog.attribute-families.edit', compact('attributeFamily', 'custom_attributes', 'groups'));
    }

    public function destroy(AttributeFamily $attributeFamily)
    {
        $attributeFamily->delete();

        Session::flash('flash', 'Набор аттрибутов был удален создануспешно');

        return redirect()->back();
    }
}
