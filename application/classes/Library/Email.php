<?php defined('SYSPATH') or die('No direct script access.');

class Library_Email
{


    /**
     * Email sent to user to reset password
     *
     * @param $user
     */
    static public function resetPassword($user)
    {

        $verify = Text::random();

        $view = new View('admin/auth/email/password-reset');
        $view->set('user', $user);
        $view->set('verify', $verify);
        $view->render();
        Library_Email::sendEmail($user->email, $view);
    }

    static private function sendEmail($to, $view)
    {

        if (Kohana::$environment == Kohana::DEVELOPMENT) {
            $to = 'jwho82@gmail.com';
        }


        require Kohana::find_file('../vendor/swiftmailer/lib', 'swift_required');

        try {

            // TODO: Test E-mails
            $email = Email::factory("Password Reset")
                ->message($view, 'text/html')
                ->to($to)
                ->from('noreply@leeka.ca', 'Admin')
                ->send();

        } catch (ORM_Validation_Exception $e) {
            Message::error($e->errors('models'));

        }

    }


}
