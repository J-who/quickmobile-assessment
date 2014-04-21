<?php
return array(
    'password' => array(
        'not_empty' => 'You must provide a password.',
        'min_length' => 'Password must be atleast :param2 characters long.',
        'password_confirm' => 'Passwords must match!',
        'regex' => 'Password must contain at least 1 uppercase and 1 lower case and 1 number',

    ),
    'password_confirm' => array(
        'min_length' => 'Must be atleast :param2 characters long.',

    ),


);

?>