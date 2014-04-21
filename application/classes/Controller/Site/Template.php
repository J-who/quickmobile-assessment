<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Template extends Controller_Template
{
    public $template = 'site/template';

    public function before()
    {
        parent::before();

        $this->id = $this->request->param('id', NULL);


        // Directory main contain a slash, let's remove that
        $this->directory = $site['directory'] = lcfirst($this->request->directory());
        $site['controller'] = $this->controller = lcfirst($this->request->controller());
        $site['action'] = $this->action = lcfirst($this->request->action());


        $seo = "-". ucfirst($this->request->action());

        $page = $this->request->param('page', NULL);
        if (!is_null($page)) {
            $menu[$page] = "active";
        } else {
            $menu[$this->controller] = "active";
        }


        $this->errors = '';
        $this->breadcrumb = new View('site/breadcrumb');
        $this->breadcrumb->bind('errors', $this->errors)
            ->bind('message', $this->message);
        $this->settings = $settings = ORM::factory('Setting')->find();

        $site['title'] = $settings->site_name;
        if ($settings->open == FALSE) {
            $site['title'] .= ' (COMING SOON)';
        }

        $site['open'] = $settings->open;
        $site['seo'] = $seo;
        $site['start_year'] = $settings->start_year;
        $site['meta_description'] = $settings->meta_description;


        // set default page title, which controllers can override
        $this->page_title = $site['action'];


        $this->template->bind('breadcrumb', $this->breadcrumb);
        $this->template->bind('site', $site);

        $this->breadcrumb->bind('site', $site);
        $this->breadcrumb->bind('page_title', $this->page_title);
        $this->template->bind('menu', $menu);
    }

    public function after()
    {
        $this->message = Message::render();

        parent::after();

    }


}