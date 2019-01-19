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
            'title' => '用户管理',

            'roles' => [
                'all'        => '所有角色',
                'create'     => '新建角色',
                'edit'       => '编辑角色',
                'management' => '角色管理',
                'main'       => '角色',
            ],

            'users' => [
                'all'             => '所有用户',
                'change-password' => '更改密码',
                'create'          => '新建用户',
                'deactivated'     => '未激活的用户',
                'deleted'         => '已删除的用户',
                'edit'            => '编辑用户',
                'main'            => '用户',
                'view'            => '查看用户',
            ],
        ],

        'forum' => [
            'title' => '论坛管理',

            'courses' => [
                'all'             => '所有课程',
                'create'          => '新建课程',
                'deleted'         => '已删除的课程',
                'edit'            => '编辑课程',
                'main'            => '课程',
                'view'            => '查看课程',
                'enroll'          => '课程订阅',
            ],

            'assignments' => [
                'all'             => '所有作业',
                'create'          => '新建作业',
                'deleted'         => '已删除的作业',
                'finished'        => '已完成的作业',
                'edit'            => '编辑作业',
                'main'            => '作业',
                'view'            => '查看作业',
            ],

            'problems' => [
                'all'             => '所有题目',
                'create'          => '新建题目',
                'deleted'         => '已删除的题目',
                'edit'            => '编辑题目',
                'main'            => '题目',
                'view'            => '查看题目',
            ],

            'posts' => [
                'all'             => '所有帖子',
                'create'          => '新建帖子',
                'deleted'         => '已删除的帖子',
                'edit'            => '编辑帖子',
                'main'            => '帖子',
                'view'            => '查看帖子',
            ],

            'notices' => [
                'all'             => '所有公告',
                'create'          => '新建公告',
                'deleted'         => '已删除的公告',
                'edit'            => '编辑公告',
                'main'            => '公告',
                'view'            => '查看公告',
            ],
        ],

        'log-viewer' => [
            'main'      => '日志查看器',
            'dashboard' => '指示板',
            'logs'      => '日志',
        ],

        'sidebar' => [
            'dashboard' => '指示板',
            'general'   => '常规',
            'history'   => '历史',
            'system'    => '系统',
            'forum'     => '论坛',
            'log'       => '记录',
        ],
    ],

    'language-picker' => [
        'language' => '语言',
        /*
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'zh_CN' => '残体中文',
            'en'    => '高级洋屁',
            'zh_TW' => '厉害之语',
        ],
    ],
];
