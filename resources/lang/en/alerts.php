<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Alert Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain alert messages for various scenarios
    | during CRUD operations. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    'backend' => [
        'roles' => [
            'created' => 'The role was successfully created.',
            'deleted' => 'The role was successfully deleted.',
            'updated' => 'The role was successfully updated.',
        ],

        'users' => [
            'cant_resend_confirmation' => 'The application is currently set to manually approve users.',
            'confirmation_email'  => 'A new confirmation e-mail has been sent to the address on file.',
            'confirmed'              => 'The user was successfully confirmed.',
            'created'             => 'The user was successfully created.',
            'deleted'             => 'The user was successfully deleted.',
            'deleted_permanently' => 'The user was deleted permanently.',
            'restored'            => 'The user was successfully restored.',
            'session_cleared'      => "The user's session was successfully cleared.",
            'social_deleted' => 'Social Account Successfully Removed',
            'unconfirmed' => 'The user was successfully un-confirmed',
            'updated'             => 'The user was successfully updated.',
            'updated_password'    => "The user's password was successfully updated.",
        ],

        'courses' => [
            'created'             => 'The course was successfully created.',
            'deleted'             => 'The course was successfully deleted.',
            'deleted_permanently' => 'The course was deleted permanently.',
            'restored'            => 'The course was successfully restored.',
            'updated'             => 'The course was successfully updated.',
        ],

        'assignments' => [
            'created'             => 'The assignment was successfully created.',
            'deleted'             => 'The assignment was successfully deleted.',
            'deleted_permanently' => 'The assignment was deleted permanently.',
            'restored'            => 'The assignment was successfully restored.',
            'updated'             => 'The assignment was successfully updated.',
        ],

        'posts' => [
            'deleted'             => 'The post was successfully deleted.',
            'deleted_permanently' => 'The post was deleted permanently.',
            'restored'            => 'The post was successfully restored.',
            'updated'             => 'The post was successfully updated.',
        ],

        'notices' => [
            'created'             => 'The notice was successfully created.',
            'deleted'             => 'The notice was successfully deleted.',
            'deleted_permanently' => 'The notice was deleted permanently.',
            'restored'            => 'The notice was successfully restored.',
            'updated'             => 'The notice was successfully updated.',
        ],
    ],

    'frontend' => [
        'posts' => [
            'created'             => 'The post was successfully created.',
            'updated'             => 'The post was successfully updated.',
        ],
    ],
];
