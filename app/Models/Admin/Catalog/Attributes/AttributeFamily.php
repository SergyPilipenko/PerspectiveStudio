<?php

namespace App\Models\Admin\Catalog\Attributes;

use App\Models\Admin\Catalog\Attributes\AttributeGroup;
use Illuminate\Database\Eloquent\Model;

class AttributeFamily extends Model
{
    protected $table = 'attribute_families';

    private $group;

    public function custom_attributes()
    {
        return Attribute::join('attribute_group_mappings', 'attributes.id', '=', 'attribute_group_mappings.attribute_id')
            ->join('attribute_groups', 'attribute_group_mappings.attribute_group_id', '=', 'attribute_groups.id')
            ->join('attribute_families', 'attribute_groups.attribute_family_id', '=', 'attribute_families.id')
            ->where('attribute_families.id', $this->id)
            ->select('attributes.*');
    }


    public function attribute_groups()
    {
        return $this->hasMany(AttributeGroup::class);
    }

    public function groupExists($group_id)
    {
        return $this->attribute_groups->contains('id', $group_id);
    }

    public function updateFamilyGroups(array $groups) : void
    {
        $familyGroups = [];
        if(count($groups)) {
            foreach ($groups as $group) {
                $group = is_string($group) ? json_decode($group, true) : $group;
                if(isset($group['group']['id']) && $this->groupExists($group['group']['id'])) {
                    $group_instance = $this->attribute_groups->where('id', $group['group']['id'])->first();
                } else {
                    $group_instance = $this->createNewAttributeGroup($group);
                }
                if(isset($group['attributes'])) {
                    $group_instance->group_attributes()->sync(array_column($group['attributes'], 'id'));
                }
                $familyGroups[] = $group_instance->id;

            }
        }
        $this->removeOldGroups($familyGroups);
    }

    public function createNewAttributeGroup(array $group) : AttributeGroup
    {
        $attributeGroup = new AttributeGroup;
        $attributeGroup->name = $group['group']['name'];
        $attributeGroup->position = $group['group']['position'];
        if(isset($group['group']['is_user_defined'])) $attributeGroup->is_user_defined = $group['group']['is_user_defined'];
        $attributeGroup->attribute_family_id = $this->id;
        $attributeGroup->save();

        return $attributeGroup;
    }

    protected function removeOldGroups($familyGroups)
    {
        foreach ($this->attribute_groups as $attribute_group) {
            if(!in_array($attribute_group->id, $familyGroups)) {
                $attribute_group->delete();
            };
        }
    }
}
