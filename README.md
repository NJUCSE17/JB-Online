# Class-Forum

*A hidden(?) place for we students.*

## Introduction

This project (originally called *Physics-Homework-Forum*) was 
 originally designed for students to  share sorrow as well as
 joy when learning University Physics. It was implemented as 
 a universal forum for students to check homework, talk about
 key points and share knowledge.

The project is based on Laravel-5-boilerplate. 
 Hence it is issued under MIT license. Besides, the 
 project employs many open source plugins, which you can learn
 more about in the 'credit' part.

## Requirement

- PHP 7.1+
  - with ``gd2``, ``path_info``, ``mbstring``, ``exif`` modules installed.
  - enabled ``proc_open`` and other functions in 
    ``php.ini`` config file.
- SQL 5.6+
- Apache (recommended) / Nginx

## Installation

You can refer to the start guide and documentation 
of Laravel-boilerplate. But there are some difference.

1. First, install dependencies using composer and npm. Run 

   ```shell
   composer install
   ```

   and

   ```shell
   npm install
   ```

2. Second, create database by making a .env file 
   and run the following commands.

   ```shell
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

   This would create an administrator user whose
   student ID is 10000 (quite like QQ, huh?) and 
   password is 'secret'. You can login using this 
   account.

3. Build your stylesheets and scripts using

   ```shell
   npm run production
   ```

   You could check all available commands inside the 
   package.json file.

4. Last but not least, create a link for storage 
folder (/public/storage) using command 

   ```
   php artisan storage:link
   ```

   and don't forget to create scheduled tasks

   ```
   crontab -e
   
   ... (your tasks)
   * * * * * php /path/to/artisan schedule:run > /path/to/log_file
   ```

   Now you can enjoy the forum!
   
5. (P.S.) If you encounter errors, please refer to 
 error log file. The most common cause to errors is 
 wrong permission. Also, you might have to change file
 names in folder ``/resources/lang/vendor`` so that 
 localized language files can be shown correctly.
 
## Customization

There four major models, assignment, course, notice
 and forum. And there are two customized commands,
 ``forum::updatefeeds`` and ``forum::checkassignments``
 which would respectively cache blog feeds and check
 assignments and send warning notifications.

## Contact

If you have any issues about safety or functions, you are welcome to open an issue to this repository.

## License and Credit

*   [Bootstrap 4](http://getbootstrap.com/) as layout framework.
*   [Carbon 2](https://carbon.nesbot.com/) and [laravel-carbon-2](https://github.com/kylekatarnls/laravel-carbon-2) for time localization and display.
*   [Elfinder](https://github.com/Studio-42/elFinder) and [laravel-elfinder](https://github.com/barryvdh/laravel-elfinder) for file storage.
*   [Glide](http://glide.thephpleague.com/) for image processing.
*   [Highlight.JS](https://highlightjs.org/) for code formatting.
*   [jQuery](http://jquery.com/), [jQuery UI](https://jqueryui.com/) and [jQuery-Confirm v3](https://github.com/craftpip/jquery-confirm) for JS based utils.
*   [Laravel 5.6](https://laravel.com/) as PHP framework.
*   [Laravel Boilerplate](http://laravel-boilerplate.com/) as code basement.
*   [MathJax](https://www.mathjax.org/) for TeX and LaTeX display.
*   [TinyMCE 4](https://www.tiny.cloud/) as WYSIWYG editor.
*   All icons from [FlatIcon](https://www.flaticon.com/).