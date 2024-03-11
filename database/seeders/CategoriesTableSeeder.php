<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        //Data Type
        $dataType = $this->dataType('name', 'navs');
        if (!$dataType->exists) {
            $dataType->fill([
                'slug' => 'navs',
                'display_name_singular' => __('voyager::seeders.data_types.category.singular'),
                'display_name_plural' => __('voyager::seeders.data_types.category.plural'),
                'icon' => 'voyager-navs',
                'model_name' => 'TCG\\Voyager\\Models\\Category',
                'controller' => '',
                'generate_permissions' => 1,
                'description' => '',
            ])->save();
        }
        //Data Rows
        $categoryDataType = DataType::where('slug', 'navs')->firstOrFail();
        $dataRow = $this->dataRow($categoryDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'number',
                'display_name' => __('voyager::seeders.data_rows.id'),
                'required' => 1,
                'browse' => 0,
                'read' => 0,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'order' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'parent_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'select_dropdown',
                'display_name' => __('voyager::seeders.data_rows.parent'),
                'required' => 0,
                'browse' => 0,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'details' => [
                    'default' => '',
                    'null' => '',
                    'options' => [
                        '' => '-- None --',
                    ],
                    'relationship' => [
                        'key' => 'id',
                        'label' => 'name',
                    ],
                ],
                'order' => 2,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'order');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'text',
                'display_name' => __('voyager::seeders.data_rows.order'),
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'details' => [
                    'default' => 1,
                ],
                'order' => 3,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'text',
                'display_name' => __('voyager::seeders.data_rows.name'),
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 4,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'slug');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'text',
                'display_name' => __('voyager::seeders.data_rows.slug'),
                'required' => 1,
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'details' => [
                    'slugify' => [
                        'origin' => 'name',
                    ],
                ],
                'order' => 5,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.created_at'),
                'required' => 0,
                'browse' => 0,
                'read' => 1,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'order' => 6,
            ])->save();
        }

        $dataRow = $this->dataRow($categoryDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type' => 'timestamp',
                'display_name' => __('voyager::seeders.data_rows.updated_at'),
                'required' => 0,
                'browse' => 0,
                'read' => 0,
                'edit' => 0,
                'add' => 0,
                'delete' => 0,
                'order' => 7,
            ])->save();
        }

        $categories = [
            ['slug' => 'bat-dong-san', 'name' => 'Bất động sản'],
            ['slug' => 'dien-may', 'name' => 'Điện máy'],
            ['slug' => 'dien-thoai', 'name' => 'Điện thoại'],
            ['slug' => 'Máy tính', 'name' => 'Máy tính'],
            ['slug' => 'dong-ho', 'name' => 'Đồng hồ'],
            ['slug' => 'do-dien-tu', 'name' => 'Đồ điện tử'],
            ['slug' => 'do-gia-dung', 'name' => 'Đồ gia dụng'],
            ['slug' => 'do-noi-that', 'name' => 'Đồ nội thất'],
            ['slug' => 'may-moc-thiet-bi', 'name' => 'Máy móc & thiết bị'],
            ['slug' => 'may-moc-thi-cong', 'name' => 'Máy móc thi công'],
            ['slug' => 'thiet-bi-van-phong', 'name' => 'Thiết bị văn phòng'],
            ['slug' => 'thiet-bi-ve-sinh', 'name' => 'Thiết bị vệ sinh'],
            ['slug' => 'xe cộ', 'name' => 'Xe cộ'],
        ];

        foreach ($categories as $categoryData) {
            \App\Models\Category::factory()->create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
            ]);
        }
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field' => $field,
        ]);
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
