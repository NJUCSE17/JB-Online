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
            'created' => '角色已成功创建。',
            'deleted' => '角色已成功删除。',
            'updated' => '角色已成功更新。',
        ],

        'users' => [
            'cant_resend_confirmation' => '系统已经设置为手动审核用户模式。',
            'confirmation_email'  => '新的确认电子邮件已发送到文件上的地址。',
            'confirmed'              => '用户已成功确认。',
            'created'             => '用户已成功创建。',
            'deleted'             => '用户已成功删除。',
            'deleted_permanently' => '用户被永久删除。',
            'restored'            => '用户已成功还原。',
            'session_cleared'     => '用户会话已成功清除。',
            'social_deleted' => '成功移除社交账号。',
            'unconfirmed' => '用户已被取消确认。',
            'updated'             => '用户已成功更新。',
            'updated_password'    => '用户密码已成功更新。',
        ],

        'courses' => [
            'created'             => '创建课程成功。',
            'deleted'             => '删除课程成功。',
            'deleted_permanently' => '课程已永久删除',
            'restored'            => '恢复课程成功。',
            'updated'             => '修改课程成功。',
        ],

        'assignments' => [
            'created'             => '创建作业成功。',
            'deleted'             => '删除作业成功。',
            'deleted_permanently' => '作业已永久删除。',
            'restored'            => '恢复作业成功。',
            'updated'             => '修改作业成功。',
        ],

        'problems' => [
            'created'             => '创建题目成功。',
            'deleted'             => '删除题目成功。',
            'deleted_permanently' => '题目已永久删除。',
            'restored'            => '恢复题目成功。',
            'updated'             => '修改题目成功。',
        ],

        'posts' => [
            'deleted'             => '删除帖子成功。',
            'deleted_permanently' => '帖子已永久删除。',
            'restored'            => '恢复帖子成功。',
            'updated'             => '修改帖子成功。',
        ],

        'notices' => [
            'created'             => '新建公告成功。',
            'deleted'             => '删除公告成功。',
            'deleted_permanently' => '公告已永久删除。',
            'restored'            => '恢复公告成功。',
            'updated'             => '修改公告成功。',
        ],
    ],

    'frontend' => [
        'posts' => [
            'created'             => '发表成功。',
            'updated'             => '修改成功。',
        ],

        'personal' => [
            'created'             => '创建PA成功。',
            'deleted'             => '删除PA成功。',
            'deleted_permanently' => 'PA已永久删除。',
            'restored'            => '恢复PA成功。',
            'updated'             => '修改PA成功。',
        ],
    ],
];
