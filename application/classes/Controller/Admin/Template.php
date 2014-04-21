<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Template extends Controller_Site_Template
{
    public $template = 'admin/template';

    public function before()
    {

        parent::before();


        if (!Auth::instance()->logged_in('login') && $this->controller != 'auth') {
            $this->redirect('admin');
        }


        if (Auth::instance()->logged_in('login')) {
            $this->user = Auth::instance()->get_user();
        }


        if (Auth::instance()->logged_in()) {
            $this->user = Auth::instance()->get_user();
            $this->user->last_active = time();
            $this->user->save();
        }

        if ($this->request->is_ajax())
            $this->auto_render = false;

        $this->id = $this->request->param('id', NULL);

        $porperties['total'] = ORM::factory('Property')->count_all();
        $porperties['unlisted'] = ORM::factory('Property')->where('published', '=', FALSE)->count_all();
        $porperties['featured'] = ORM::factory('Property')->where('published', '=', TRUE)->where('featured', '=', TRUE)->count_all();


        $menu[$this->controller] = "active";
        // if (!empty($directory)) $menu[$action] = "active";

        $this->template->set('page_title', $this->request->controller());

        $this->menu = $menu;
        $this->template->set('menu', $menu);
        $this->template->set('porperties', $porperties);
        $this->template->set('controller', $this->directory);
        $this->template->set('user', $this->user);




    }

}