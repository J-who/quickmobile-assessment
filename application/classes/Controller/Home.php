<?php

/**
 * Copyright (c) 2013 All Rights Reserved - Leeka Media http://www.leeka.ca/
 *
 * @copyright Leeka Media 2013
 * @author Chris Hopewell <chris.hopewell@leeka.ca>
 */
class Controller_Home extends Controller_Site_Template
{

    public function action_index()
    {
        $view = new View('home/index');
        $this->template->set('content', $view);
        $this->response->body($view);
    }

    public function action_crunch()
    {
        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);

            // TODO - make sure URL is valid

            // Make sure URL has been set!
            if (!isset($post['url'])) {
                Message::error('URL is missing!');
                $this->redirect('/');
            }

            $url = $post['url'];
            // Remove http:// if user is sneaky!
            if (strpos($url, 'http://') !== false) {
                $url = substr($url, 7);
            }

            if ($post->check()) {
                $this->redirect("hash/$url");
            }
        }
        $this->redirect('/');
    }


    public function action_hash()
    {

        $url = $this->request->param('url');

        try {

            // Hashing URL
            $url = ORM::factory('Url')->hashURL($url);

        } catch (ORM_Validation_Exception $e) {
            Message::error($e->errors('models'));
            $this->redirect('/');
        }

        $view = new View('home/crunch');
        $view->set('url', $url);
        $this->template->set('content', $view);
        $this->response->body($view);
    }


    public function action_hashed()
    {

        $url = $this->request->param('url', NULL);

        $model = ORM::factory('Url')->getHashed($url);

        if (!$model->loaded()) {
            Message::error('Invalid URL');
            $this->redirect('/');
        }

        $view = new View('home/redirect');
        $view->set('model', $model);
        $this->template->set('content', $view);
        $this->response->body($view);
    }


}