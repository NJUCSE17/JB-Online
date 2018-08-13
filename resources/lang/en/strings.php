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
                'delete_user_confirm'  => 'Are you sure you want to delete this user permanently? Anywhere in the application that references this user\'s id will most likely error. Proceed at your own risk. This can not be un-done.',
                'if_confirmed_off'     => '(If confirmed is off)',
                'no_deactivated' => 'There are no deactivated users.',
                'no_deleted' => 'There are no deleted users.',
                'restore_user_confirm' => 'Restore this user to its original state?',
            ],
        ],

        'forum' => [
            'courses' => [
                'delete_course_confirm'  => 'Are you sure you want to delete this course permanently? Anywhere in the application that references this user\'s id will most likely error. Proceed at your own risk. This can not be un-done.',
                'no_deleted' => 'There are no deleted courses.',
            ],

            'assignments' => [
                'delete_assignment_confirm'  => 'Are you sure you want to delete this assignment permanently? Anywhere in the application that references this user\'s id will most likely error. Proceed at your own risk. This can not be un-done.',
                'no_deleted' => 'There are no deleted assignments.',
            ],

            'posts' => [
                'delete_assignment_confirm'  => 'Are you sure you want to delete this post permanently? Anywhere in the application that references this user\'s id will most likely error. Proceed at your own risk. This can not be un-done.',
                'no_deleted' => 'There are no deleted posts.',
            ],

            'notices' => [
                'delete_assignment_confirm'  => 'Are you sure you want to delete this notice permanently? This can not be un-done.',
                'no_deleted' => 'There are no deleted notices.',
            ],
        ],

        'dashboard' => [
            'title'   => 'Dashboard',
            'welcome' => 'Welcome',
        ],

        'general' => [
            'all_rights_reserved' => 'All Rights Reserved.',
            'are_you_sure'        => 'Are you sure you want to do this?',
            'boilerplate_link'    => 'Laravel 5 Boilerplate',
            'continue'            => 'Continue',
            'member_since'        => 'Member since',
            'minutes'             => ' minutes',
            'search_placeholder'  => 'Search...',
            'timeout'             => 'You were automatically logged out for security reasons since you had no activity in ',

            'see_all' => [
                'messages'      => 'See all messages',
                'notifications' => 'View all',
                'tasks'         => 'View all tasks',
            ],

            'status' => [
                'online'  => 'Online',
                'offline' => 'Offline',
            ],

            'you_have' => [
                'messages'      => '{0} You don\'t have messages|{1} You have 1 message|[2,Inf] You have :number messages',
                'notifications' => '{0} You don\'t have notifications|{1} You have 1 notification|[2,Inf] You have :number notifications',
                'tasks'         => '{0} You don\'t have tasks|{1} You have 1 task|[2,Inf] You have :number tasks',
            ],
        ],

        'search' => [
            'empty'      => 'Please enter a search term.',
            'incomplete' => 'You must write your own search logic for this system.',
            'title'      => 'Search Results',
            'results'    => 'Search Results for :query',
        ],

        'welcome' => '<p>Tired to translate. See Chinese (ZH) version for instruction.</p>',
    ],

    'emails' => [
        'auth' => [
            'account_confirmed'       => 'Your account has been confirmed.',
            'error'                   => 'Whoops!',
            'greeting'                => 'Hello!',
            'regards'                 => 'Regards,',
            'trouble_clicking_button' => 'If you’re having trouble clicking the ":action_text" button, copy and paste the URL below into your web browser:',
            'thank_you_for_using_app' => 'Thank you for using our application!',

            'password_reset_subject'    => 'Reset Password',
            'password_cause_of_email'   => 'You are receiving this email because we received a password reset request for your account.',
            'password_if_not_requested' => 'If you did not request a password reset, no further action is required.',
            'reset_password'            => 'Click here to reset your password',

            'click_to_confirm' => 'Click here to confirm your account:',
        ],

        'reply' => [
            'email_body_title' => 'You got a new reply and below is the content.',
            'subject' => 'Reply Notification from :app_name',
        ],
    ],

    'frontend' => [

        'test' => 'Test',

        'tests' => [
            'based_on' => [
                'permission' => 'Permission Based - ',
                'role'       => 'Role Based - ',
            ],

            'js_injected_from_controller' => 'Javascript Injected from a Controller',

            'using_blade_extensions' => 'Using Blade Extensions',

            'using_access_helper' => [
                'array_permissions'     => 'Using Access Helper with Array of Permission Names or ID\'s where the user does have to possess all.',
                'array_permissions_not' => 'Using Access Helper with Array of Permission Names or ID\'s where the user does not have to possess all.',
                'array_roles'           => 'Using Access Helper with Array of Role Names or ID\'s where the user does have to possess all.',
                'array_roles_not'       => 'Using Access Helper with Array of Role Names or ID\'s where the user does not have to possess all.',
                'permission_id'         => 'Using Access Helper with Permission ID',
                'permission_name'       => 'Using Access Helper with Permission Name',
                'role_id'               => 'Using Access Helper with Role ID',
                'role_name'             => 'Using Access Helper with Role Name',
            ],

            'view_console_it_works'          => 'View console, you should see \'it works!\' which is coming from FrontendController@index',
            'you_can_see_because'            => 'You can see this because you have the role of \':role\'!',
            'you_can_see_because_permission' => 'You can see this because you have the permission of \':permission\'!',
        ],

        'general' => [
            'joined'        => 'Joined',
        ],

        'user' => [
            'change_email_notice' => 'If you change your e-mail you will be logged out until you confirm your new e-mail address.',
            'email_changed_notice' => 'You must confirm your new e-mail address before you can log in again.',
            'profile_updated'  => 'Profile successfully updated.',
            'password_updated' => 'Password successfully updated.',
            'avatar_restriction' => 'Restriction: maximum file size 100 kilobytes, dimension < 200x200 (px^2).'
        ],

        'jumbo_title' => 'Hello, world!',
        'welcome_to' => 'Welcome to :place',

        'home' => [
            'home'  => 'Home',
            'title' => 'Title',
            'semester' => [
                'left'  => 'Semester',
                'right' => '',
            ],
            'no_notice'     => 'Nothing here.',
            'no_ongoing'    => 'No course now.',
            'no_assignment' => 'Oops! No assignments to do now.',
            'total' => [
                'left'  => 'Found',
                'right' => 'course(s) in total.'
            ]
        ],

        'courses' => [
            'no_notice' => 'No notice for course.',
            'no_assignment' => 'No assignment yet.',
        ],

        'breadcrumb' => [
            'home'       => 'Home',
            'course'     => 'Course',
            'assignment' => 'Assignment',
            'post' => [
                'edit' => 'Edit',
            ]
        ],

        'about' => '<h1>About</h1>
            <p>The JB Stack Exchange is a site originally intended for we elite class students the joy and 
            sorrow about University Physics&nbsp;<span style="text-decoration: line-through;">as well as 
            other insane subjects.</span> Forum members are supposed to follow the following rules or they 
            shall be kicked out.</p>
            <ol>
            <li>No copying answers from others.</li>
            <li>No sharing answers if the course is marked w/&nbsp;
            <span class="badge badge-red">No answer</span>.</li>
            <li>Neither upload files violating the law nor delete others files w/o permission.</li>
            </ol>
            <h1>How to use</h1>
            <p>The JB Stack Exchange is equipped with tons of open source tools and is issued under MIT 
            license. Here are the major tips for you.</p>
            <ol>
            <li>JBEX is equipped with the latest version of MathJax. You can use LaTeX as you do problem 
            -solving assignments (note that we do not support macros and some custom functions). As an 
            example, \$...\$ would transform into an inline equation like $y = x^2$, while \$\$ ... \$\$ 
            would transform into a block equation such as $$ S = \sum\limits_{i=1}^{n} i$$ But if you want 
            to insert a dollar sign, just type \'\\\$\'.</li>
            <li>Highlight.JS helps we to display codes in a well-formatted way.
            <pre class="language-cpp"><code>#include 
using namespace std;
int main() {
  cout &lt;&lt; "Hello, World!";
  return 0;
}​</code></pre>
            To insert a part of code, click \'Insert/Edit code sample\' in your editor, select your target 
            language and paste your code. It\'s simple and handy.</li>
            <li>JBEX employs ElFinder for image and file drive. If you want to insert a photo in your post, 
            just click \'Insert/edit image\', the EF2 window would pop up and you can upload your image 
            (which should be no bigger than 2 megabytes). However, everyone has the same privilege&nbsp;in 
            modifying the files, so remember to keep the folder neat and avoid deleting others\' files!&nbsp;</li>
            </ol>
            <h1>Contact</h1>
            <p>If you have any issue about safety or functionality, please get in touch with the webmaster. 
            You can submit issues on the&nbsp;<a href="https://github.com/doowzs/Physics-Homework-Forum" 
            target="_blank" rel="noopener">GitHub page</a> of the project which helps a lot.</p>',
    ],
];
