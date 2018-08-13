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
        'all'     => '全部',
        'yes'     => '是',
        'no'      => '否',
        'copyright' => '版权所有',
        'custom'  => '自定义',
        'actions' => '操作',
        'active'  => '激活',
        'buttons' => [
            'save'   => '保存',
            'update' => '更新',
        ],
        'hide'              => '隐藏',
        'inactive'          => '禁用',
        'none'              => '空',
        'show'              => '显示',
        'toggle_navigation' => '切换导航',
        'course'            => '课程',
        'assignment'        => '作业',
        'post'              => '帖子',
        'notice'            => '公告',
        'published'         => '发表于',
        'updated'           => '修改于',
        'ddl'               => 'DDL',
        'at'                => '在',
        'by'                => '由',
        'day'               => '天',
        'hour'              => '小时',
        'minute'            => '分钟',
        'remain'            => '剩余',
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create'     => '新建角色',
                'edit'       => '编辑角色',
                'management' => '角色管理',

                'table' => [
                    'number_of_users' => '用户数',
                    'permissions'     => '权限',
                    'role'            => '角色',
                    'sort'            => '排序',
                    'total'           => '角色总计',
                ],
            ],

            'users' => [
                'active'              => '有效用户',
                'all_permissions'     => '所有权限',
                'change_password'     => '更改密码',
                'change_password_for' => '为 :user 更改密码',
                'create'              => '新建用户',
                'deactivated'         => '已停用的用户',
                'deleted'             => '已删除的用户',
                'edit'                => '编辑用户',
                'management'          => '用户管理',
                'no_permissions'      => '没有权限',
                'no_roles'            => '没有角色可设置',
                'permissions'         => '权限',

                'table' => [
                    'confirmed'      => '确认',
                    'created'        => '创建',
                    'student_id'     => '学号',
                    'email'          => '电子邮件',
                    'id'             => 'ID',
                    'last_updated'   => '最后更新',
                    'name'           => '名称',
                    'no_deactivated' => '没有停用的用户',
                    'no_deleted'     => '没有删除的用户',
                    'roles'          => '角色',
                    'other_permissions' => '其他权限',
                    'social'         => '社交账户',
                    'total'          => '用户总计',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => '概述',
                        'history'  => '历史',
                    ],

                    'content' => [
                        'overview' => [
                            'avatar'       => '头像',
                            'confirmed'    => '已确认',
                            'created_at'   => '创建于',
                            'deleted_at'   => '删除于',
                            'student_id'   => '学号',
                            'email'        => '电子邮件',
                            'last_login_at' => 'Last Login At',
                            'last_login_ip' => 'Last Login IP',
                            'last_updated' => '最后更新',
                            'name'         => '名称',
                            'status'       => '状态',
                            'timezone'     => 'Timezone',
                        ],
                    ],
                ],

                'view' => '查看用户',
            ],
        ],

        'forum' => [
            'courses' => [
                'create'              => '新建课程',
                'deleted'             => '已删除的课程',
                'edit'                => '编辑课程',
                'management'          => '课程管理',
                'active'              => '有效课程',

                'table' => [
                    'confirmed'      => '确认',
                    'created'        => '创建',
                    'id'             => 'ID',
                    'last_updated'   => '最后更新',
                    'name'           => '名称',
                    'no_deleted'     => '没有删除的课程',
                    'total'          => '课程总计',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => '概述',
                        'history'  => '历史',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => '创建于',
                            'deleted_at'   => '删除于',
                            'last_updated' => '最后更新',
                            'name'         => '名称',
                            'status'       => '状态',
                        ],
                    ],
                ],

                'view' => '查看课程',
            ],

            'assignments' => [
                'create'              => '新建作业',
                'deleted'             => '已删除的作业',
                'edit'                => '编辑作业',
                'management'          => '作业管理',
                'active'              => '有效作业',

                'table' => [
                    'course_id'       => '课程',
                    'name'            => '名称',
                    'content'         => '内容',
                    'due_time'        => '截止日期',
                    'total'           => '作业总计'
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => '概述',
                        'history'  => '历史',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => '创建于',
                            'deleted_at'   => '删除于',
                            'last_updated' => '最后更新',
                            'name'         => '名称',
                            'status'       => '状态',
                        ],
                    ],
                ],

                'view' => '查看作业',
            ],

            'posts' => [
                'create'              => '新建帖子',
                'deleted'             => '已删除的帖子',
                'edit'                => '编辑帖子',
                'management'          => '帖子管理',
                'active'              => '有效帖子',

                'table' => [
                    'course_id'       => '课程',
                    'assignment_id'   => '作业',
                    'parent_id'       => '回复给',
                    'user_id'         => '用户',
                    'rating'          => '评分',
                    'content'         => '内容',
                    'total'           => '帖子总计',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => '概述',
                        'history'  => '历史',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => '创建于',
                            'deleted_at'   => '删除于',
                            'last_updated' => '最后更新',
                            'name'         => '名称',
                            'status'       => '状态',
                        ],
                    ],
                ],

                'view' => '查看帖子',
            ],

            'notices' => [
                'create'              => '新建公告',
                'deleted'             => '已删除的公告',
                'edit'                => '编辑公告',
                'management'          => '公告管理',
                'active'              => '有效公告',

                'table' => [
                    'user_id'         => '用户',
                    'content'         => '内容',
                    'last_updated'    => '最后更新于',
                ],

                'tabs' => [
                    'titles' => [
                        'overview' => '概述',
                        'history'  => '历史',
                    ],

                    'content' => [
                        'overview' => [
                            'created_at'   => '创建于',
                            'deleted_at'   => '删除于',
                            'last_updated' => '最后更新',
                            'name'         => '名称',
                            'status'       => '状态',
                        ],
                    ],
                ],

                'view' => '查看公告',
            ],

        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title'    => '登录',
            'login_button'       => '登录',
            'login_with'         => '使用 :social_media 登录',
            'register_box_title' => '注册',
            'register_button'    => '注册',
            'remember_me'        => '记住我',
        ],

        'passwords' => [
            'forgot_password'                 => '忘记密码了？',
            'reset_password_box_title'        => '重置密码',
            'reset_password_button'           => '重置密码',
            'send_password_reset_link_button' => '发送密码重置链接',
        ],

        'macros' => [
            'country' => [
                'alpha'   => 'Country Alpha Codes',
                'alpha2'  => 'Country Alpha 2 Codes',
                'alpha3'  => 'Country Alpha 3 Codes',
                'numeric' => 'Country Numeric Codes',
            ],

            'macro_examples' => 'Macro Examples',

            'state' => [
                'mexico' => 'Mexico State List',
                'us'     => [
                    'us'       => 'US States',
                    'outlying' => 'US Outlying Territories',
                    'armed'    => 'US Armed Forces',
                ],
            ],

            'territories' => [
                'canada' => 'Canada Province & Territories List',
            ],

            'timezone' => '时区',
        ],

        'user' => [
            'passwords' => [
                'change' => '更改密码',
            ],

            'profile' => [
                'avatar'             => '头像',
                'created_at'         => '创建于',
                'edit_information'   => '编辑信息',
                'student_id'         => '学号',
                'email'              => '电子邮件',
                'last_updated'       => '最后更新',
                'name'               => '名称',
                'update_information' => '更新信息',
            ],
        ],


        'home' => [
            'notice'        => '首页公告',
            'ongoing'       => '正在进行',
            'others'        => '其他课程',
            'assignment'    => '当前作业',
        ],

        'forum' => [
            'new_reply' => '发新帖 / 回复',

            'courses' => [
                'status' => [
                    'pending' => '未开始',
                    'ongoing' => '进行中',
                    'ended'   => '已结束',
                ],

                'difficulty' => [
                    'easy' => '简单',
                    'medium' => '中等',
                    'hard' => '困难',
                    'insane' => '骨灰',
                ],

                'restriction' => [
                    'free' => '自由',
                    'restricted' => '限制',
                    'forbidden' => '无答案',
                ],

                'assignment_list' => '作业列表',
                'course_notice'   => '课程公告',
            ]
        ]
    ],
];
