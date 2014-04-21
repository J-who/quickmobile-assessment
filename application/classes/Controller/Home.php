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

            if ($post->check()) {
                $this->redirect("hash/$post[url]");

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

        $url = ORM::factory('Url')->getHashed($url);

        if (!$url->loaded()) {
            Message::error('Invalid URL');
            $this->redirect('/');
        }

        $view = new View('home/redirect');
        $view->set('url', $url);
        $this->template->set('content', $view);
        $this->response->body($view);
    }


}