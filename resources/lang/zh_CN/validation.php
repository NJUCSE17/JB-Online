<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute 必须接受。',
    'active_url'           => ':attribute 不是一个有效的网址。',
    'after'                => ':attribute 必须要晚于 :date。',
    'after_or_equal'       => ':attribute 必须要等于 :date 或更晚。',
    'alpha'                => ':attribute 只能由字母组成。',
    'alpha_dash'           => ':attribute 只能由字母、数字和斜杠组成。',
    'alpha_num'            => ':attribute 只能由字母和数字组成。',
    'array'                => ':attribute 必须是一个数组。',
    'before'               => ':attribute 必须要早于 :date。',
    'before_or_equal'      => ':attribute 必须要等于 :date 或更早。',
    'between'              => [
        'numeric' => ':attribute 必须介于 :min - :max 之间。',
        'file'    => ':attribute 必须介于 :min - :max kb 之间。',
        'string'  => ':attribute 必须介于 :min - :max 个字符之间。',
        'array'   => ':attribute 必须只有 :min - :max 个单元。',
    ],
    'boolean'              => ':attribute 必须为布尔值。',
    'confirmed'            => ':attribute 两次输入不一致。',
    'date'                 => ':attribute 不是一个有效的日期。',
    'date_format'          => ':attribute 的格式必须为 :format。',
    'different'            => ':attribute 和 :other 必须不同。',
    'digits'               => ':attribute 必须是 :digits 位的数字。',
    'digits_between'       => ':attribute 必须是介于 :min 和 :max 位的数字。',
    'dimensions'           => ':attribute 图片尺寸不正确。',
    'distinct'             => ':attribute 已经存在。',
    'email'                => ':attribute 不是一个合法的邮箱。',
    'exists'               => ':attribute 不存在。',
    'file'                 => ':attribute 必须是文件。',
    'filled'               => ':attribute 不能为空。',
    'gt'                   => [
        'numeric' => ':attribute 必须大于 :value 。',
        'file'    => ':attribute 必须大于 :value KB。',
        'string'  => ':attribute 必须多于 :value 个字符。',
        'array'   => ':attribute 必须多于 :value 个。',
    ],
    'gte'                  => [
        'numeric' => ':attribute 必须大于或等于 :value 。',
        'file'    => ':attribute 必须大于或等于 :value KB。',
        'string'  => ':attribute 必须多于或等于 :value 字符。',
        'array'   => ':attribute 必须多于或等于 :value 个。',
    ],
    'image'                => ':attribute 必须是图片。',
    'in'                   => '已选的属性 :attribute 非法。',
    'in_array'             => ':attribute 没有在 :other 中。',
    'integer'              => ':attribute 必须是整数。',
    'ip'                   => ':attribute 必须是有效的 IP 地址。',
    'ipv4'                 => ':attribute 必须是合法的 IPv4 地址.',
    'ipv6'                 => ':attribute 必须是合法的 IPv6 地址.',
    'json'                 => ':attribute 必须是正确的 JSON 格式。',
    'lt'                   => [
        'numeric' => ':attribute 必须小于 :value 。',
        'file'    => ':attribute 必须小于 :value KB。',
        'string'  => ':attribute 必须少于 :value 个字符。',
        'array'   => ':attribute 必须少于 :value 个。',
    ],
    'lte'                  => [
        'numeric' => ':attribute 必须小于或等于 :value 。',
        'file'    => ':attribute 必须小于或等于 :value KB。',
        'string'  => ':attribute 必须少于或等于 :value 个字符。',
        'array'   => ':attribute 必须少于或等于 :value 个。',
    ],
    'max'                  => [
        'numeric' => ':attribute 不能大于 :max。',
        'file'    => ':attribute 不能大于 :max kb。',
        'string'  => ':attribute 不能大于 :max 个字符。',
        'array'   => ':attribute 最多只有 :max 个单元。',
    ],
    'mimes'                => ':attribute 必须是一个 :values 类型的文件。',
    'mimetypes'            => ':attribute 必须是一个 :values 类型的文件。',
    'min'                  => [
        'numeric' => ':attribute 必须大于等于 :min。',
        'file'    => ':attribute 大小不能小于 :min kb。',
        'string'  => ':attribute 至少为 :min 个字符。',
        'array'   => ':attribute 至少有 :min 个单元。',
    ],
    'not_in'               => '已选的属性 :attribute 非法。',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => ':attribute 必须是一个数字。',
    'present'              => ':attribute 必须存在。',
    'regex'                => ':attribute 格式不正确。',
    'required'             => ':attribute 不能为空。',
    'required_if'          => '当 :other 为 :value 时 :attribute 不能为空。',
    'required_unless'      => '当 :other 不为 :value 时 :attribute 不能为空。',
    'required_with'        => '当 :values 存在时 :attribute 不能为空。',
    'required_with_all'    => '当 :values 存在时 :attribute 不能为空。',
    'required_without'     => '当 :values 不存在时 :attribute 不能为空。',
    'required_without_all' => '当 :values 都不存在时 :attribute 不能为空。',
    'same'                 => ':attribute 和 :other 必须相同。',
    'size'                 => [
        'numeric' => ':attribute 大小必须为 :size。',
        'file'    => ':attribute 大小必须为 :size kb。',
        'string'  => ':attribute 必须是 :size 个字符。',
        'array'   => ':attribute 必须为 :size 个单元。',
    ],
    'string'               => ':attribute 必须是一个字符串。',
    'timezone'             => ':attribute 必须是一个合法的时区值。',
    'unique'               => ':attribute 已经存在。',
    'uploaded'             => ':attribute 上传失败。',
    'url'                  => ':attribute 格式不正确。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => '定制信息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [

        'backend' => [
            'access' => [
                'permissions' => [
                    'associated_roles' => '关联的角色',
                    'dependencies'     => '依赖关系',
                    'display_name'     => '显示名称',
                    'group'            => '群组',
                    'group_sort'       => '组排序',

                    'groups' => [
                        'name' => '组名称',
                    ],

                    'name'   => '名称',
                    'system' => '系统?',
                ],

                'roles' => [
                    'associated_permissions' => '关联的权限',
                    'name'                   => '名称',
                    'sort'                   => '排序',
                ],

                'users' => [
                    'active'                  => '激活',
                    'associated_roles'        => '关联的角色',
                    'confirmed'               => '已确认',
                    'student_id'              => '学号',
                    'last_name'               => '姓',
                    'first_name'              => '名',
                    'want_mail'               => '接收邮件',
                    'email'                   => '电子邮件地址',
                    'blog'                    => '博客Feed地址',
                    'name'                    => '名称',
                    'other_permissions'       => '其他权限',
                    'password'                => '密码',
                    'password_confirmation'   => '确认密码',
                    'send_confirmation_email' => '发送确认电子邮件',
                ],
            ],

            'forum' => [
                'courses' => [
                    'name'              => '名称',
                    'semester'          => '学期',
                    'start_time'        => '开始于',
                    'end_time'          => '结束于',
                    'notice'            => '公告',
                    'difficulty'        => '难度',
                    'difficulty_label' => [
                        '0' => '简单',
                        '1' => '中等',
                        '2' => '困难',
                        '3' => '骨灰',
                    ],
                    'restrict_level'    => '限制级别',
                    'restrict_level_label' => [
                        '0' => '自由',
                        '1' => '限制',
                        '2' => '无答案',
                    ],
                ],

                'assignments' => [
                    'course_id'         => '课程',
                    'name'              => '名称',
                    'content'           => '内容',
                    'due_time'          => '截止时间',
                ],

                'problems' => [
                    'course_id'         => '课程',
                    'assignment_id'     => '作业',
                    'permalink'         => '网址',
                    'content'           => '内容',
                    'difficulty'        => '难度',
                ],

                'posts' => [
                    'content'           => '内容',
                ],

                'notices' => [
                    'content'           => '内容',
                    'sendmail'          => '邮件通知',
                ],
            ],
        ],

        'frontend' => [
            'avatar'                    => '头像文件地址',
            'student_id'                => '学号',
            'first_name'                => '姓名',
            'last_name'                 => '姓（英语专用）',
            'want_mail'                 => '接收邮件',
            'email'                     => '电子邮件',
            'blog'                      => '博客Feed地址（没有请留空）',
            'name'                      => '用户名',
            'password'                  => '密码',
            'password_confirmation'     => '确认密码',
            'phone'                     => '电话',
            'message'                   => '消息',
            'old_password'              => '旧密码',
            'new_password'              => '新密码',
            'new_password_confirmation' => '确认新密码',
            'timezone'                  => '时区',
            'language'                  => '语言',
            'content'                   => '内容',
        ],
    ],
];
