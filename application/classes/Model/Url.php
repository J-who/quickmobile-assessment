<?php defined('SYSPATH') OR die('No direct access allowed.');
// Not being used. Here for examples

class Model_Url extends ORM
{
    protected $_created_column = array('column' => 'date_added', 'format' => 'Y-m-d H:i:s');
    //protected $_sorting = array('project_order' => 'asc');





    public function filters()
    {
    }


    public function hashURL($url)
    {
        $model = $this->getURL($url);

        // Check to see if someone already hashed the URL
        if ($model->loaded()) return $model;

        // Lets hash this URL

        $hashed = URL::title(Text::random());

        /*
        $hashed = "";
        $character_set = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        for ($i = 1; $i <= 6; $i++) {
            $hashed .= $character_set[rand(0, strlen($character_set) - 1)];
        }
        */

        if ($this->getHashed($hashed)->loaded()) {
            $this->hashURL($url);
        }

        // Save it
        $model->url = $url;
        $model->hashed = $hashed;
        $model->save();

        return $model;

    }


    public function getURL($url)
    {
        return $this->where('url', '=', $url)->find();
    }

    public function getHashed($hashed)
    {
        return $this->where('hashed', '=', $hashed)->find();

    }

}