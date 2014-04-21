<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Copyright (c) 2013 All Rights Reserved - Leeka Media http://www.leeka.ca/
 *
 * @copyright Leeka Media 2013
 * @author Chris Hopewell <chris.hopewell@leeka.ca>
 */


class Controller_Admin_Settings extends Controller_Admin_Template
{

    public function action_index()
    {
        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);
            if ($post->check()) {

                try {
                    $this->settings->values($this->request->post());

                    $this->settings->open = isset($post['open']);
                    $this->settings->show_dates = isset($post['show_dates']);

                    $this->settings->save();
                    Message::SUCCESS("Your Settings have been saved");
                } catch (ORM_Validation_Exception $e) {
                    $this->errors = $e->errors('models');
                    Message::ERROR($e->errors('models'));
                }
            }
        }


        $view = new View('admin/settings/edit');
        $view->bind('settings', $this->settings);

        $this->template->set('content', $view);
        $this->response->body($view);
    }
}