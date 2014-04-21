<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Property extends Controller_Admin_Template
{

    public function action_index()
    {
        $properties = ORM::factory('Property')->getAllProperties();


        $view = new View("$this->directory/$this->controller/$this->action");
        $view->bind('properties', $properties);
        $this->template->set('content', $view);
        $this->response->body($view);

    }

    public function action_featured()
    {
        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);

            if ($post->check()) {

                try {
                    foreach ($post['order'] as $id => $order) {
                        $property = ORM::factory('Property')->getProperty($id);
                        $property->feature_order = $order;
                        $property->save();
                }

                } catch (ORM_Validation_Exception $e) {
                    Message::error($e->errors('models'));
                }
            }
            $this->redirect('admin/property/featured');
        }

        $properties = ORM::factory('Property')->getFeatured();

        $view = new View("$this->directory/$this->controller/$this->action");
        $view->bind('properties', $properties);
        $this->template->set('content', $view);
        $this->response->body($view);

    }

    public function action_edit()
    {
        // Load Asset in to edit
        $property = ORM::factory('Property')->getProperty($this->id);
        $categories = ORM::factory('Property_Category')->getCategories(TRUE);

        if (HTTP_Request::POST == $this->request->method()) {
            $post = Validation::factory($_POST);

            if ($post->check()) {

                try {

                    //$property->featureOrderUpdate($post['featured']);

                    $property->values($this->request->post());

                    // Existing Property
                    if ($property->loaded()) $property->url_name = URL::title($post['name'])."-".$property->id;
                    $property->featured = isset($post['featured']);
                    $property->published = isset($post['published']);
                    $property->furnished = isset($post['furnished']);
                    $property->pets = isset($post['pets']);
                    $property->smoking = isset($post['smoking']);
                    $property->postal_code = strtoupper(str_replace('-', '', $post['postal_code']));

                    if (!empty($property->featured) && empty($property->feature_order)) {
                        $featured = ORM::Factory('Property')->getFeatured()->count();
                        $property->feature_order = $featured + 1;
                    }
                    $property->save();

                    // New Properties
                    if (empty($property->url_name)) {
                        $property->url_name = URL::title($post['name'])."-".$property->id;
                        $property->save();
                    }


                    Message::SUCCESS("Property Saved");
                    //$this->redirect("admin/property/edit/$property");


                    if (isset($post['submit'])) {

                        //echo "<script> $('.modal').hide();</script>";
                        $this->redirect("admin/property/");
                    }


                } catch (ORM_Validation_Exception $e) {
                    Message::error($e->errors('models'));
                }
            } else {
                Message::error($post->errors('models'));

                foreach ($this->request->post() as $key => $value) {
                    $property->$key = $value;
                }
            }
        }

        $message = Message::render();

        $view = new View("$this->directory/$this->controller/$this->action");
        $view->bind('property', $property);
        $view->bind('categories', $categories);
        $view->bind('message', $message);
        $this->template->set('content', $view);
        $this->response->body($view);
    }


    public function action_delete()
    {
        $client = ORM::factory('Property')->getProperty($this->id);
        $client->delete();

    }

    /**
     * Handles the image uploading script
     */
    public function action_upload()
    {
        $upload_handler = new Library_UploadHandler();

        $property = ORM::Factory('Property')->getProperty($this->id);
        $image = $property->images;

        $image->image = $upload_handler->filename;
        $image->property_id = $property;
        $image->save();

    }

    public function action_toggle()
    {
        $property = ORM::factory('Property')->getProperty($this->id);

        if ($property->loaded()) {
            $property->published = (!isset($property->published)) ? TRUE : NULL;
            $property->save();
        }
    }


    public function action_deleteimage()
    {
        exit;
    }

    public function action_featureimage()
    {

        $image = ORM::factory('Property_Image')->where('id', '=', $this->id)->find();


        if (!$image->loaded()) $this->redirect('/');

        // Find the old featured image through the property.
        // And remove the feature flag
        $property = $image->property;
        $old = $property->images->where('featured', '=', TRUE)->find();
        if ($old->loaded()) {
            $old->featured = NULL;
            try {
                $old->save();
            } catch (ORM_Validation_Exception $e) {
                Message::error($e->errors('models'));
            }
        }


        // Set new image to featured!
        try {
            $image->featured = TRUE;
            $image->save();
        } catch (ORM_Validation_Exception $e) {
            Message::error($e->errors('models'));
        }

    }

}
