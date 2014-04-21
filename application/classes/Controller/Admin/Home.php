<?php
/**
 * Copyright (c) 2013 All Rights Reserved - Leeka Media http://www.leeka.ca/
 *
 * @copyright Leeka Media 2013
 * @author Chris Hopewell <chris.hopewell@leeka.ca>
 */


class Controller_Admin_Home extends Controller_Admin_Template
{


    public function action_index()
    {

        $view = new View('admin/home');
        $this->template->set('content', $view);
        $this->template->set('title', 'Home');
        $this->response->body($view);
    }
} 