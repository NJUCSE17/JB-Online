<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all'     => 'All',
        'yes'     => 'Yes',
        'no'      => 'No',
        'copyright' => 'Copyright',
        'custom'  => 'Custom',
        'actions' => 'Actions',
        'active'  => 'Active',
        'buttons' => [
            'save'   => 'Save',
            'update' => 'Update',
        ],
        'contents'          => 'Contents',
        'hide'              => 'Hide',
        'inactive'          => 'Inactive',
        'none'              => 'None',
        'show'              => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
        'course'            => 'Course',
        'enroll'            => 'Enrollment',
        'assignment'        => 'Assignment',
        'problem'           => 'Problem',
        'post'              => 'Post',
        'notice'            => 'Notice',
        'published'         => 'Posted',
        'updated'           => 'Updated',
        'ddl'               => 'DDL',
        'at'                => 'at',
        'by'                => 'by',
        'day'               => 'Day',
        'hour'              => 'Hour',
        'minute'            => 'Min',
        'remain'            => 'Remaining',
        'personal_data'     => 'Personal',
        'deleted_data'      => 'Deleted',
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create'     => 'Create Role',
                'edit'       => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions'     => 'Permissions',
                    'role'            => 'Role',
                    'sort'            => 'Sort',
                    'total'           => 'role total|roles total',
                ],
            ],

            'users' => [
                'active'              => 'Active Users',
                'all_permissions'     => 'All Permissions',
                'change_password'     => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create'              => 'Create User',
                'deactivated'         => 'Deactivated Users',
                'deleted'             => 'Deleted Users',
                'edit'                => 'Edit User',
                'management'          => 'User Management',
                'no_permissions'      => 'No Permissions',
                'no_roles'            => 'No Roles to set.',
                'permissions'         => 'Permissions',

                'table' => [
                    'confirmed'      => 'Confirmed',
                    'created'        => 'Created',
                    'student_id'     => 'Student ID',
                    'email'          => 'E-mail',
                    'blog'           => 'Blog',
                    'id'             => 'ID',
                    'last_updated'   => 'Last Updated',
                    'name'           => 'Name',
                    'first_name'     => 'First Name',
                    'last_name'      => 'Last Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted'     => 'No Deleted Users',
                    'other_permissions' => 'Other Permissions',
                    'permissions' => 'Permissions',
                    'roles'          => 'Roles',
                    'social' => 'Social',
                    'total'          => 'user total|users total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => 'Avatar',
                            'confirmed'    => 'Confirmed',
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'student_id'   => 'Student ID',
                            'email'        => 'E-mail',
                            'last_login_at' => 'Last Login At',
                            'last_login_ip' => 'Last Login IP',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                            'first_name'   => 'First Name',
                            'last_name'    => 'Last Name',
                            'status'       => 'Status',
                            'timezone'     => 'Timezone',
                        ],
                    ],
                ],

                'view' => 'View User',
            ],
        ],

        'forum' => [
            'courses' => [
                'create'              => 'Create Course',
                'deleted'             => 'Deleted Courses',
                'edit'                => 'Edit Course',
                'management'          => 'Course Management',
                'active'              => 'Active Courses',

                'table' => [
                    'name'            => 'Name',
                    'semester'        => 'Semester',
                    'start_time'      => 'Start',
                    'end_time'        => 'End',
                    'notice'          => 'Notice',
                    'difficulty'      => 'Difficulty',
                    'restrict_level'  => 'Restriction',
                    'total'           => 'in total'
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                        ],
                    ],
                ],

                'view' => 'View Course',
            ],

            'assignments' => [
                'create'              => 'Create Assignment',
                'deleted'             => 'Deleted Assignments',
                'edit'                => 'Edit Assignment',
                'management'          => 'Assignment Management',
                'active'              => 'Active Assignments',
                'finished'            => 'Finished Assignments',

                'table' => [
                    'course_id'       => 'Course ID',
                    'name'            => 'Name',
                    'content'         => 'Content',
                    'due_time'        => 'Due',
                    'total'           => 'in total'
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                        ],
                    ],
                ],

                'view' => 'View Assignment',
            ],

            'problems' => [
                'create'              => 'Create Problem',
                'deleted'             => 'Deleted Problems',
                'edit'                => 'Edit Problem',
                'management'          => 'Problem Management',
                'active'              => 'Active Problems',

                'table' => [
                    'course_id'       => 'Course ID',
                    'assignment_id'   => 'Assignment ID',
                    'permalink'       => 'Permalink',
                    'content'         => 'Content',
                    'difficulty'      => 'Difficulty',
                    'updated_at'      => 'Updated At',
                    'total'           => 'in total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                        ],
                    ],
                ],

                'view' => 'View Problem',
            ],

            'posts' => [
                'create'              => 'Create Post',
                'deleted'             => 'Deleted Posts',
                'edit'                => 'Edit Post',
                'management'          => 'Post Management',
                'active'              => 'Active Posts',

                'table' => [
                    'course_id'       => 'Course ID',
                    'assignment_id'   => 'Assignment ID',
                    'parent_id'       => 'Reply to',
                    'user_id'         => 'User ID',
                    'editor_id'       => 'Editor ID',
                    'rating'          => 'Rating',
                    'content'         => 'Content',
                    'updated_at'      => 'Updated At',
                    'total'           => 'in total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                        ],
                    ],
                ],

                'view' => 'View Post',
            ],

            'notices' => [
                'create'              => 'Create Notice',
                'deleted'             => 'Deleted Notices',
                'edit'                => 'Edit Notice',
                'management'          => 'Notice Management',
                'active'              => 'Active Notices',

                'table' => [
                    'user_id'         => 'Creator',
                    'editor_id'       => 'Editor',
                    'content'         => 'Content',
                    'updated_at'      => 'Updated At',
                    'last_updated'    => 'Last Updated',
                    'total'           => 'in total',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => 'Overview',
                        'history'  => 'History',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => 'Created At',
                            'deleted_at'   => 'Deleted At',
                            'last_updated' => 'Last Updated',
                            'name'         => 'Name',
                        ],
                    ],
                ],

                'view' => 'View Notice',
            ],
        ],
    ],

    'frontend' => [

        'auth' => [
            'not_logged_in'      => 'Not logged in',
            'login_box_title'    => 'Login',
            'login_button'       => 'Login',
            'login_with'         => 'Login with :social_media',
            'register_box_title' => 'Register',
            'register_button'    => 'Register',
            'remember_me'        => 'Remember Me',
        ],

        'passwords' => [
            'expired_password_box_title' => 'Your password has expired.',
            'forgot_password'                 => 'Forgot Your Password?',
            'reset_password_box_title'        => 'Reset Password',
            'reset_password_button'           => 'Reset Password',
            'update_password_button'           => 'Update Password',
            'send_password_reset_link_button' => 'Send Password Reset Link',
        ],

        'user' => [
            'passwords' => [
                'change' => 'Change Password',
            ],

            'profile' => [
                'avatar'             => 'Avatar',
                'created_at'         => 'Created At',
                'edit_information'   => 'Edit Information',
                'student_id'         => 'Student ID',
                'email'              => 'E-mail',
                'blog'               => 'Blog',
                'last_updated'       => 'Last Updated',
                'name'               => 'Name',
                'first_name'         => 'First Name',
                'last_name'          => 'Last Name',
                'update_information' => 'Update Information',
            ],
        ],

        'home' => [
            'heatmap'       => 'Heatmap',
            'notice'        => 'Bulletin',
            'ongoing'       => 'My Courses',
            'others'        => 'Other Courses',
            'personal'      => 'Personal',
            'course'        => 'All',
            'assignment'    => 'Assignments',
            'login'         => 'User Login',
            'login_button'  => 'Login',
            'class_blog'    => 'Class Blog',
        ],

        'forum' => [
            'new_reply' => 'New Post / Reply',

            'courses' => [
                'status' => [
                    'pending' => 'Pending',
                    'ongoing' => 'Ongoing',
                    'ended'   => 'Ended',
                ],

                'difficulty' => [
                    'easy' => 'Easy',
                    'medium' => 'Medium',
                    'hard' => 'Hard',
                    'insane' => 'Insane',
                ],

                'restriction' => [
                    'free' => 'Free',
                    'restricted' => 'Restricted',
                    'forbidden' => 'No answer',
                ],

                'assignment_list' => 'Assignments List',
                'course_notice'   => 'Course Notice',
                'personal_panel'  => 'Control Panel',
            ],

            'assignments' => [
                'assignment_content' => 'Assignment Content',
                'post_list'          => 'Post List',
            ],

            'posts' => [
                'edit' => 'Post Edit',
            ],

            'personal' => [
                'management' => 'PA Management',
                'create'     => 'Create PA',
                'edit'       => 'Edit PA',
                'deleted'    => 'Deleted PAs',
                'table' => [
                    'name'     => 'Name',
                    'content'  => 'Content',
                    'due_time' => 'DDL',
                    'total'    => 'PAs in total',
                ]
            ]
        ]
    ],
];
