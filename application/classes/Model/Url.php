<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Url extends ORM
{
    protected $_created_column = array('column' => 'date_added', 'format' => 'Y-m-d H:i:s');
    //protected $_sorting = array('project_order' => 'asc');


    /**
     * Hashing a URL
     *
     * @param $url
     * @return ORM
     */
    public function hashURL($url)
    {

        // Check to see if someone already hashed the URL
        $model = $this->getURL($url);
        if ($model->loaded()) return $model;

        // Lets hash this URL
        $hashed = URL::title(Text::random());

        // Make sure it doesn't exist already
        if ($this->getHashed($hashed)->loaded()) {
            $this->hashURL($url);
        }

        // Save it
        $model->url = $url;
        $model->hashed = $hashed;
        $model->save();

        return $model;

    }

    /**
     * Loading in the model via URL
     *
     * @param $url
     * @return ORM
     */
    public function getURL($url)
    {
        return $this->where('url', '=', $url)->find();
    }

    /**
     * Loading in the model via hashed URL
     *
     * @param $hashed
     * @return ORM
     */
    public function getHashed($hashed)
    {
        return $this->where('hashed', '=', $hashed)->find();

    }

}