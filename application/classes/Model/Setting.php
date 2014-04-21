<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Setting extends ORM {

    public function rules()
    {
        return array(
            'site_name' => array(
                array('not_empty'),
                array('max_length', array(':value', 64)),
            ),

        );
    }


}