<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menus Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in menu items throughout the system.
    | Regardless where it is placed, a menu item can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'title' => 'Access',

            'roles' => [
                'all'        => 'All Roles',
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',
                'main'       => 'Roles',
            ],

            'users' => [
                'all'             => 'All Users',
                'change-password' => 'Change Password',
                'create'          => 'Create User',
                'deactivated'     => 'Deactivated Users',
                'deleted'         => 'Deleted Users',
                'edit'            => 'Edit User',
                'main'            => 'Users',
                'view'            => 'View User',
            ],
        ],

        'forum' => [
            'title' => 'Forum',

            'courses' => [
                'all'             => 'All Courses',
                'create'          => 'Create Course',
                'deleted'         => 'Deleted Courses',
                'edit'            => 'Edit Course',
                'main'            => 'Courses',
                'view'            => 'View Course',
            ],

            'assignments' => [
                'all'             => 'All Assignments',
                'create'          => 'Create Assignment',
                'deleted'         => 'Deleted Assignments',
                'edit'            => 'Edit Assignment',
                'main'            => 'Assignments',
                'view'            => 'View Assignment',
            ],

            'problems' => [
                'all'             => 'All Problems',
                'create'          => 'Create Problem',
                'deleted'         => 'Deleted Problems',
                'edit'            => 'Edit Problem',
                'main'            => 'Problems',
                'view'            => 'View Problem',
            ],

            'posts' => [
                'all'             => 'All Posts',
                'create'          => 'Create Post',
                'deleted'         => 'Deleted Posts',
                'edit'            => 'Edit Post',
                'main'            => 'Posts',
                'view'            => 'View Post',
            ],
        ],

        'log-viewer' => [
            'main'      => 'Log Viewer',
            'dashboard' => 'Dashboard',
            'logs'      => 'Logs',
        ],

        'sidebar' => [
            'dashboard' => 'Dashboard',
            'general'   => 'General',
            'history'   => 'History',
            'system'    => 'System',
            'forum'     => 'Forum',
            'log'       => 'Log',
        ],
    ],

    'language-picker' => [
        'language' => 'Language',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'zh_CN' => 'Chinese Simplified(中文)',
            'en'    => 'English',
            'zh_TW' => 'Amazing Language(嘤语)',
        ],
    ],
];
