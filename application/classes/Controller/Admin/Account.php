<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Account extends Controller_Admin_Template
{


    public function action_index()
    {

        $accounts = ORM::factory('User')->getUsers();


        $view = new View("$this->directory/$this->controller/$this->action");
        $view->bind('accounts', $accounts);
        $this->template->set('content', $view);
        $this->response->body($view);
    }


    /**
     * Allows the user to edit and save their profile
     */
    public function action_edit()
    {

        $user = ORM::factory('User')->getUser($this->id);

        // Save an account
        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);


            if ($post->check()) {

                try {
                    if ($user->loaded()) {
                        $user->update_user($_POST);
                    } else {
                        $user->create_user($_POST, array('first_name', 'last_name', 'email', 'password'));
                    }

                    Message::success("Account has been updated");
                    $this->redirect('admin/account');

                } catch (ORM_Validation_Exception $e) {
                    Message::error($e->errors('models'));
                }
            } else {
                Message::error($post->errors('models'));
            }
        }

        $view = new View("$this->directory/$this->controller/$this->action");
        $view->bind('user', $user);
        $this->template->set('content', $view);
        $this->response->body($view);

    }



    public function action_password()
    {

        // Save an account
        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);

            // if we are not editing a user, lets check out password rules


            if ($post->check()) {

                if (!Auth::instance()->check_password($post['old_password'])) {
                    Message::error("Current Password was incorrect");

                } else {


                    //$this->user->values($this->request->post());

                    try {
                        $this->user->update_user($_POST);

                        Message::success("Your Password has been updated");
                        $this->redirect('panel/account/password');

                    } catch (ORM_Validation_Exception $e) {
                        Message::error($e->errors('models'));
                    }
                }
            } else {
                Message::error($post->errors('models'));
            }
        }

        $view = new View('admin/account/password');
        $view->set('user', $this->user);
        $this->template->set('content', $view);
        $this->response->body($view);
    }



    public function action_delete()
    {
        // Check Account Role
        $user = ORM::factory('User')->getUser($this->id);
        if (!$user->loaded()) $this->redirect('admin');

        if ($user->roles->has('roles', ORM::factory('role', array('name' => 'admin')))) $this->redirect('admin');

        // Only Delete non Admins & user isnt current user
        if ($this->user == $user) $this->redirect('admin');

        $user->delete();


    }

}
