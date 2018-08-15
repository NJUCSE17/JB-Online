<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Strings Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in strings throughout the system.
    | Regardless where it is placed, a string can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'users' => [
                'delete_user_confirm'  => '您确定要永久删除此用户吗？引用此用户ID的任何地方都很可能导致错误。继续需要自行承担风险。此操作不能被撤消。',
                'if_confirmed_off'     => '(已确认则无效)',
                'restore_user_confirm' => '将此用户恢复到其原始状态？',
            ],
        ],

        'forum' => [
            'courses' => [
                'delete_course_confirm'  => '你确定要删除吗？此操作不可撤销。',
                'no_deleted' => '没有已经删除的课程。',
            ],

            'assignments' => [
                'delete_assignment_confirm'  => '你确定要删除吗？此操作不可撤销。',
                'no_deleted' => '没有已经删除的作业。',
            ],

            'posts' => [
                'delete_assignment_confirm'  => '你确定要删除吗？此操作不可撤销。',
                'no_deleted' => '没有已经删除的帖子。',
            ],

            'notices' => [
                'delete_assignment_confirm'  => '你确定要删除吗？此操作不可撤销。',
                'no_deleted' => '没有已经删除的公告。',
            ],
        ],

        'dashboard' => [
            'title'   => '管理仪表板',
            'welcome' => '欢迎',
        ],

        'general' => [
            'all_rights_reserved' => '保留所有权利。',
            'are_you_sure'        => '你确定这样做吗？',
            'boilerplate_link'    => 'Laravel 5 Boilerplate',
            'continue'            => '继续',
            'member_since'        => '会员自',
            'minutes'             => ' 分钟',
            'search_placeholder'  => '搜索...',
            'timeout'             => '出于安全原因已自动注销，因为你没有操作超过 ',

            'see_all' => [
                'messages'      => '查看所有消息',
                'notifications' => '查看所有提醒',
                'tasks'         => '查看所有任务',
            ],

            'status' => [
                'online'  => '在线',
                'offline' => '离线',
            ],

            'you_have' => [
                'messages'      => '{0} 你没有消息|{1} 你有 1 条消息|[2,Inf] 你有 :number 条消息',
                'notifications' => '{0} 你没有提醒|{1} 你有 1 条提醒|[2,Inf] 你有 :number 条提醒',
                'tasks'         => '{0} 你没有任务|{1} 你有 1 个任务|[2,Inf] 你有 :number 个任务',
            ],
        ],

        'search' => [
            'empty'      => '请输入搜索关键词。',
            'incomplete' => '您必须为此系统编写您自己的搜索逻辑。',
            'title'      => '搜索结果',
            'results'    => '搜索 :query 的结果',
        ],

        'welcome' => '<p>欢迎来到管理后台。</p>
<p>编辑公告时，只需要发一个新的空的公告即可删除首页显示的公告。</p>
<p>所有删除都是可以恢复的，注意不要手滑彻底删除了，否则只能改数据库了。</p>',
    ],

    'emails' => [
        'auth' => [
            'account_confirmed' => '你的账户已经被确认',
            'error'                   => '哎呀！',
            'greeting'                => '你好！',
            'regards'                 => '问候,',
            'trouble_clicking_button' => '如果您在点击 ":action_text" 按钮时遇到问题, 请将以下网址复制并粘贴到您的网络浏览器中:',
            'thank_you_for_using_app' => '谢谢您使用我们的应用程序！',

            'password_reset_subject'    => '重置密码',
            'password_cause_of_email'   => '您收到此电子邮件是因为我们收到了您帐户的密码重设请求',
            'password_if_not_requested' => '如果您没有请求重置密码，则无需进一步操作',
            'reset_password'            => '点击这里重置密码',

            'click_to_confirm' => '点击此处确认您的帐户:',
        ],

        'reply' => [
            'email_body_title' => '你收到了新的回复，内容如下',
            'subject' => '来自 :app_name 的回复通知',
        ],
    ],

    'frontend' => [
        'test' => '测试',

        'tests' => [
            'based_on' => [
                'permission' => '基于权限 - ',
                'role'       => '基于角色 - ',
            ],

            'js_injected_from_controller' => '从控制器注入的Javascript',

            'using_blade_extensions' => '使用Blade扩展',

            'using_access_helper' => [
                'array_permissions'     => '访问控制-用户拥有的权限Name或权限ID数组必须完全匹配.',
                'array_permissions_not' => '访问控制-用户拥有的权限Name或权限ID数组不必完全匹配',
                'array_roles'           => '访问控制-用户拥有的角色Name或角色ID数组必须完全匹配',
                'array_roles_not'       => '访问控制-用户拥有的角色Name或角色ID数组不必完全匹配',
                'permission_id'         => '访问控制-用户拥有指定权限ID',
                'permission_name'       => '访问控制-用户拥有指定权限Name',
                'role_id'               => '访问控制-用户拥有指定角色ID',
                'role_name'             => '访问控制-用户拥有指定角色Name',
            ],

            'view_console_it_works'          => '检查 console, 你应该看到来自 FrontendController@index 的 \'it works!\' ',
            'you_can_see_because'            => '看到这条信息是因为你拥有角色 \':role\'!',
            'you_can_see_because_permission' => '看条这条信息是因为你拥有权限 \':permission\'!',
        ],

        'general' => [
            'joined'        => '加入',
        ],

        'user' => [
            'change_email_notice' => '如果你更改你的邮件地址，你会被登出系统直到你确认你的新邮件地址。',
            'email_changed_notice' => '在登录之前，你必须确认你的新邮件地址。',
            'profile_updated'  => '个人资料更新成功。',
            'password_updated' => '密码修改成功。',
            'avatar_restriction' => '头像尺寸不超过200x200像素，文件大小最大100KB。',
        ],

        'jumbo_title' => 'Hello, world!',
        'welcome_to' => '欢迎来到 :place',

        'home' => [
            'home'  => '主页',
            'title' => '标题',
            'semester' => [
                'left'  => '第',
                'right' => '学期',
            ],
            'no_notice'     => '管理员还没有发布公告……',
            'no_ongoing'    => '没有现在正在进行的课程。',
            'no_assignment' => '天哪，现在竟然没有作业！',
            'total' => [
                'left'  => '共找到',
                'right' => '门让你充实又快乐的课程。',
            ],
            'not_logged_in' => '登陆后查看更多内容。',
        ],

        'courses' => [
            'no_notice' => '这门课程没有公告。',
            'no_assignment' => '这门课程还没有发布作业。',
        ],

        'assignments' => [
            'no_post'       => '现在还没有人发帖……',
        ],

        'breadcrumb' => [
            'home'       => '主页',
            'course'     => '课程',
            'assignment' => '作业',
            'post' => [
                'edit' => '编辑',
            ]
        ],

        'about' => '<h1>关于</h1>
            <p>JBEX (JB Stack Exchange) 本是为了交流灾难般的大学物理&nbsp;
            <span style="text-decoration: line-through;">和其他课程</span>从而减轻学习的痛苦而设计的。
            论坛成员应遵守以下规则：</p>
            <ol>
            <li>不抄袭别人的答案；</li>
            <li>标有&nbsp;<span class="badge badge-red">无答案</span>的课程中不贴答案。</li>
            <li>不上传违法内容，不随意删除他人上传的内容。</li>
            </ol>
            <h1>帮助</h1>
            <p>JBEX使用了很多开源的脚本来让你享受无与伦比的交流体验。下面是对主要内容的介绍。</p>
            <ol>
            <li>我们使用了最新版本的MathJax。 你可以像做问求作业一样使用LaTeX （注意我们并没有引入宏，
            所以一些作业中的高级指令并不能使用）， 也就是说 \$...\$ 会变成像 $y = x^2$ 的行内等式，
            而 \$\$ ... \$\$ 会变成 $$ S = \sum\limits_{i=1}^{n} i$$ 一样的行间等式。
            如果你想要插入美元符号，使用 \'\\\$\'。</li>
            <li>Highlight.JS 让代码看起来不辣眼睛。
            <pre class="language-cpp"><code>#include 
using namespace std;
int main() {
  cout &lt;&lt; "Hello, World!";
  return 0;
}​</code></pre>
            要插入一段代码，直接在编辑器中点击插入代码，选择语言，粘贴确认即可。</li>
            <li>对于文件上传，我们使用ElFinder2。你可以上传不超过2MB的图片。问题是文件权限是公开的，所以其他人也可以查看、修改，
            千万不要把别人的文件随便删了。
            </ol>
            <h1>联系</h1>
            <p>如果你有什么好想法或者关于安全方面的建议，请联系管理员或在本网站的&nbsp;
            <a href="https://github.com/doowzs/Physics-Homework-Forum" 
            target="_blank" rel="noopener">GitHub</a>页面上提交issue。</p>',
    ],
];
