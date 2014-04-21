<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Property_Category extends Controller_Admin_Template {

    public function action_index()
    {
        $categories = ORM::factory('Property_Category')->getCategories();


        $view = new View("$this->directory/$this->controller/$this->action");
        $view->bind('categories', $categories);
        $this->template->set('content', $view);
        $this->response->body($view);

    }

    public function action_edit()
    {
        // Load Asset in to edit
        $category = ORM::factory('Property_Category')->getCategory($this->id);

        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);

            if ($post->check()) {

                try {

                    $category->values($this->request->post());
                    $category->save();

                    Message::SUCCESS("Property Category Saved");
                    $this->redirect('admin/property/category');

                } catch (ORM_Validation_Exception $e) {
                    Message::error($e->errors('models'));
                }
            } else {
                Message::error($post->errors('models'));

                foreach($this->request->post() as $key => $value) {
                    $category->$key = $value;
                }
            }
        }

        $view = new View("$this->directory/$this->controller/$this->action");
        $view->bind('category', $category);
        $this->template->set('content', $view);
        $this->response->body($view);
    }


    public function action_delete()
    {
        $client = $this->user->getProperty($this->id);
        $client->delete();

    }

    public function action_display()
    {
        $category_name = $this->request->param('name', NULL);
        $mode = $this->request->param('mode', NULL);

        $category = $this->user->getCompanyByName($category_name);

        if (!$category->loaded()) $this->redirect('/');

        if ($mode == 'invoices') {
            $invoices = $category->owings->getInvoices();
        } else {
            $content = $category->hours->getHours();
        }


        $title = "$category->name - $mode";
        $view = new View("$this->directory/invoice/index");
        $view->bind('company', $category);
        $view->bind('content', $content);
        $view->bind('invoices', $invoices);
        $this->template->set('content', $view);
        $this->template->set('page_title', $title);

        $this->response->body($view);
    }



}
