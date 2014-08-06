<?php

class ProductsController extends ListController{

    public function loadIdCategoryItems(){
        $return = array();
        Category::buildTreeArrayForSelect($return);

        return $return;
    }


    public function loadIdSectionItems(){
        return Q::create('sections')->select('id, title')->useValue('title')
            ->indexBy('id')->exec();
    }


    public function loadIdBrandItems(){
        $brands = Q::create('brands')->select('id, title')->useValue('title')
            ->indexBy('id')->exec();
        $res = array(0=>'');
        $res += (is_array($brands) ? $brands : array());
        return $res;
    }

    public function actionUploadImage() {
        if(!$this->route->isXHR() || !($model = $this->route->getVar('model')) || !($id = $this->route->getVar('id')))
            die();
        error_reporting(0);
        $object = new ProductImage();
        $_FILES['image'] = $_FILES['other_images'];
        unset($_FILES['other_images']);
        $data['title'] = substr($_FILES['image']['name'], 0, strpos($_FILES['image']['name'], '.'));
        $data['title'] = ffInflector::slugify($data['title']);
        $data['id_product'] = !empty($id) ? $id : 0;
        $data['_position'] = Q::create('products_images')->select('_position')
            ->useValue('_position')
            ->one()
            ->orderBy('_position DESC')
            ->where(array('id_product'=>$id))
            ->exec();
        $data['_position'] = intval($data['_position'])+1;

        $object->mergeData($data);
        @$object->save();
        $arr = $object->loadFiles()->toArray(true);
        echo json_encode(array('object'=>$arr));
        die();
    }

    public function afterSuccessfulSave($data, $object = null, $was_new = false){
        if (isset($data['photos']) && is_array($data['photos']) && count($data['photos'])) {
            $photos = ProductImage::loadList(array_keys($data['photos']));

            foreach ($data['photos'] as $id => $row) {
                if (!$photos->getOne($id)) continue;

                $o = $photos->getOne($id);
                if (isset($row['delete'])) {
                    $o->delete();
                }
            }
        }
        Q::create('products_properties')->delete(array('id_product'=>$object->id))->exec();
        if(isset($data['product_properties']) && !empty($data['product_properties']) && is_array($data['product_properties'])) {
            $properties = Q::create('properties')->select()->indexBy('id')->where(C::create(array('id'=>array_keys($data['product_properties']))))->exec();
            foreach($data['product_properties'] as $id_property => $values) {
                if(!is_array($properties) || !array_key_exists($id_property, $properties))
                    continue;
                $property = $properties[$id_property];
                if($property['multiple'] && is_array($values) && !empty($values)) {
                    foreach($values as $value) {
                        $value = trim(strip_tags($value));
                        if(empty($value) || $value=='')
                            continue;
                        $prop_obj = new ProductProperty();
                        $prop_obj->mergeData(array(
                            'id_product' => $object->id,
                            'id_property' => $id_property,
                            'value' => $value,
                        ));
                        $prop_obj->save(true);
                    }
                }else {
                    $values = trim(strip_tags($values));
                    if(empty($values) || $values=='')
                        continue;
                    $prop_obj = new ProductProperty();
                    $prop_obj->mergeData(array(
                        'id_product' => $object->id,
                        'id_property' => $id_property,
                        'value' => $values,
                    ));
                    $prop_obj->save(true);
                }
            }
        }
    }

    public function actionSaveOrderGalleryElements() {
        if(!$this->route->isXHR() || !($data = $this->route->getVar('data')))
            die();
        $model = $this->route->getVar('model');
        foreach($data as $el) {
            $object = call_user_func(array($model, 'loadOne'), array($this->_key=>$el['el_id']));
            if($object) {
                $object->_position = $el['el_pos'];
                $object->save();
            }
        }
        die();
    }

    public function actionReloadSections() {
        $id_category = $this->route->getVar('value');
        $sections = Q::create('sections')->select('id, title')->where(array('id_category'=>$id_category))->exec();
        if(!$id_category || empty($sections) || !is_array($sections)) {
            echo json_encode(array());
            die();
        }
        echo json_encode($sections);
        die();
    }
}
