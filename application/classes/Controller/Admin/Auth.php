<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Auth extends Controller_Site_Template
{

    public $template = 'site/login_template';


    public function action_index()
    {

        $this->redirect('admin/auth/login');

    }


    public function action_login()
    {

        // user already logged in, redirect to dashboard
        if (Auth::instance()->logged_in('login')) {
            $this->redirect('admin/home');
        }

        // received the POST
        if (isset($_POST) && Valid::not_empty($_POST)) {

            // validate the login form
            $post = Validation::factory($_POST)
                ->rule('email', 'not_empty')
                ->rule('password', 'not_empty')
                ->rule('password', 'min_length', array(':value', 3));
            $remember = isset($post['remember']);


            //TODO use email or username login
            // if the form is valid and the username and password matches
            if ($post->check() && Auth::instance()->login($post['email'], $post['password'], $remember)) {
                if (Auth::instance()->logged_in('login')) {
                    // successfully logged

                    $this->redirect('admin/home');

                }
            } else {
                // wrong username or password (but form is valid)
                Message::error('Bad Username or password');

            }
            // validation failed, collect the errors
            unset($post);
        }

        if ($this->request->is_ajax())
            echo "<script>window.location.reload()</script>";


        $message = Message::render();

        $view = View::factory('admin/auth/login')
            ->bind('post', $post)
            ->bind('message', $message);

        $this->template->set('content', $view);
        $this->response->body($view);


    }

    public function action_logout()
    {


        Auth::instance()->logout();
        $this->redirect('/');

    }

    public function action_passwordreset()
    {

        if (HTTP_Request::POST == $this->request->method()) {

            $post = Validation::factory($_POST);
            ORM::factory('User')->resetPassword($post['email']);

            $view = View::factory('admin/auth/password-complete');

        } else {
            $view = View::factory('admin/auth/password-reset');
        }


        $this->template->set('content', $view);
        $this->response->body($view);
    }

    public function action_passwordverify()
    {
        $verify = $this->request->query('verify');
        $email = $this->request->query('email');

        $user = ORM::factory('User')->getByEmail($email);
        if (!$user->loaded()) $this->redirect('/');

        $reset_token = $user->resets->find();
        if (!$reset_token->loaded()) $this->redirect('/');

        if ($reset_token->token == $verify && $reset_token->used == FALSE) {
            if (HTTP_Request::POST == $this->request->method()) {


                try {
                    // Update User Password
                    $user->update_user($_POST, array('password'));

                    $reset_token->used = TRUE;
                    $reset_token->save();

                    Message::success('Password has been updated');
                    $this->redirect('admin');
                } catch (ORM_Validation_Exception $e) {
                    Message::error($e->errors('models'));
                }

            }
                $view = View::factory('admin/auth/password-new');
                $view->set('email', $email);
                $view->set('verify', $verify);
                $view->bind('message', $this->message);
                $this->template->set('content', $view);
                $this->response->body($view);

        } else {

            $this->redirect('/');
        }
    }
}