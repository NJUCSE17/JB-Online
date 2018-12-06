# JB Online

**Note:** The project has changed its name from "Class-Forum" 
to "JB Online". 

This is the public code repository for JB Online 
website, based on Laravel 5.6 and written in PHP 7+.

## Installation

Requirements:
- PHP 7.1+
  - with ``gd2``, ``path_info``, ``mbstring``, ``exif`` modules installed.
  - enabled ``proc_open`` and other functions in 
    ``php.ini`` config file.
- SQL 5.6+
- Apache (recommended) / Nginx

You can refer to the start guide and documentation 
of Laravel-boilerplate. But there are some difference.

1. First, install dependencies using composer and npm. Run 

   ```shell
   composer install
   npm install
   ```

2. Second, create database by copying a .env file 
   and run the following commands.

   ```shell
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   php artisan passport:install --force
   php artisan storage:link
   ```

   This would create an administrator whose
   student ID is 10000 and password is 'secret'. 
   You can login using this account.
   
   As a reminder, if you cloned the repository using Git,
   you have to pay special attention to the file privileges
   or you may suffer from finding the cause of HTTP 500 errors.

3. (optional) Build **minimized** stylesheets and scripts using

   ```shell
   npm run production
   ```

4. Don't forget to create scheduled tasks

   ```
   crontab -e
   
   ... (your tasks)
   * * * * * php /path/to/artisan schedule:run > /path/to/log_file
   ```

   Now you can enjoy the forum!
 
6. Caching
    ```
    php artisan config:cache
    php artisan route:cache
    ```
    helps to cache configure file and routes. To disable caching, use 'clear' instead.
 
## API and commands

JB Online now provides basic APIs, described as follow:

- ``/api/login``, authorize with POST request, return a
    token, user id and name on success.
- ``/api/logout``, revoke the token.
- ``/api/assignments``, fetch all ongoing assignments in 
    JSON object array.
- ``/api/notice``, fetch the current notice.

All APIs except login requires authentication by including
passport token in request header. On a failure attempt, a 401
or 'auth failure' will be returned.

JB Online has 2 kernel commands described below:
- ``forum::updatefeeds`` caches feeds for 30 min intervals.
- ``forum::checkassignments`` checks assignments that will due 
soon (today and tomorrow) and send warning emails at 22:30.

## Contact

If you have any issues about safety or functions, you are welcome to open an issue to this repository.
Questions about how to install/modify codes are not welcomed.

## License and Credit

*   [Bootstrap 4](http://getbootstrap.com/) as layout framework.
*   [Carbon 2](https://carbon.nesbot.com/) and [laravel-carbon-2](https://github.com/kylekatarnls/laravel-carbon-2) for time localization and display.
*   [Elfinder](https://github.com/Studio-42/elFinder) and [laravel-elfinder](https://github.com/barryvdh/laravel-elfinder) for file storage.
*   [Glide](http://glide.thephpleague.com/) for image processing.
*   [Headroom.js](https://github.com/WickyNilliams/headroom.js) for hiding navigation bar.
*   [Highlight.JS](https://highlightjs.org/) for code formatting.
*   [jQuery](http://jquery.com/), [jQuery UI](https://jqueryui.com/) and [jQuery-Confirm v3](https://github.com/craftpip/jquery-confirm) for JS based utils.
*   [Laravel 5.6](https://laravel.com/) as PHP framework.
*   [Laravel Boilerplate](http://laravel-boilerplate.com/) as code basement.
*   [MathJax](https://www.mathjax.org/) for TeX and LaTeX display.
*   [TinyMCE 4](https://www.tiny.cloud/) as WYSIWYG editor.
*   All icons from [FlatIcon](https://www.flaticon.com/).