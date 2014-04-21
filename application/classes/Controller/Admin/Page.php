<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Page extends Controller_Admin_Template
{

    public function before()
    {

        if ($this->request->action() == 'preview')
            $this->template = 'site/template';

        parent::before();

    }


    public function action_index()
    {

        $pages = ORM::factory('Page')->getAllPages();

        $view = new View('admin/page/index');
        $view->set('pages', $pages);

        $this->template->set('content', $view);
        $this->response->body($view);
    }

    public function action_edit()
    {
        $page = ORM::factory('Page')->getPage($this->id);

        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);

            if ($post->check()) {

                try {

                    $page->values($this->request->post());
                    $page->url_name = URL::title($post['name']);
                    $page->user_id =  $this->user;
                    $page->save();

                    Message::SUCCESS("Page Saved");
                    $this->redirect("admin/page/");



                } catch (ORM_Validation_Exception $e) {
                    Message::error($e->errors('models'));
                }
            } else {
                Message::error($post->errors('models'));

                foreach($this->request->post() as $key => $value) {
                    $page->$key = $value;
                }
            }
        }


        if (!$page->loaded()) $page->published = TRUE;

        $view = new View('admin/page/edit');
        $view->bind('page', $page);
        $this->template->set('content', $view);
        $this->response->body($view);

    }

    public function action_preview()
    {

        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);
            $content = $post['content'];

        } else {
            $page = ORM::factory('Page')->where('id', '=', $this->id)->find();
            $content = $page->content;


        }
        $view = new View('admin/page/preview');
        $view->bind('content', $content);
        $this->template->set('content', $view);
        $this->response->body($view);

    }

    public function action_delete()
    {
        $page = ORM::factory('Page')
            ->where('id', '=', $this->id)
            ->find();

        if (!$page->loaded()) $this->redirect('admin/page/list');

        Message::SUCCESS('Page has been removed');

        $page->delete();


    }

    public function action_updateorder()
    {
        // Save Tag
        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);

            // if we are not editing a user, lets check out password rules


            if ($post->check()) {

                foreach ($post['page'] as $page => $value) {

                    $value = round($value, 2);

                    $page = ORM::factory('Page')
                        ->where('id', '=', $page)
                        ->find();
                    try {
                        // Only update pages with a new order
                        if ($page->order != $value) {
                            $page->order = $value;
                            $page->save();
                        }
                        Message::SUCCESS('Page order updated!');

                    } catch (ORM_Validation_Exception $e) {
                        Message::error($e->errors('models'));
                    }
                }

                $this->redirect('admin/page/list');


            }
        }
    }


}