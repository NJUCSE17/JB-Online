### Physics-Homework-Forum

*A hidden place for we students.*

#### Introduction

This project was originally designed for students to share sorrow as well as joy when learning University Physics. It was implemented as a universal forum for students to check homework, talk about key points and share knowledge.

The project is based on Laravel-5-boilerplate. Hence it is issued under MIT license. Besides, the project employs many open source plugins: Bootstrap, font-awesome 5, MathJax, TinyMCE, HighlightJS, ElFinder, Glide, et cetera.

#### Glance

The site is built using Laravel 5.6, and has frontend and backend panel. The frontend is divided into 3 layers, the home page, the course page and the assignment page. You can add courses, assignments and notice in the background, but you can only create new posts in the frontend (you can edit in both side). The forum is served in 3 languages: English, Simplified Chinese and ~~Amazing Chinese~~ (LOL). You can change the default one in .env file.

#### How to use

You can refer to the start guide and documentation of Laravel-boilerplate. But there are some difference.

1. First, install dependencies using composer and npm. Run 

   ```shell
   composer install
   ```

   and

   ```shell
   npm install
   ```

2. Second, create database by making a .env file and run the following commands.

   ```shell
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

   This would create an administrator user whose student ID is 10000 (quite like QQ, huh?) and password is 'secret'. You can login using this account.

3. Build your stylesheets and scripts using

   ```shell
   npm run production
   ```

   You could check the commands inside the package.json file.

4. Last, create a link for storage folder (/public/storage) using command 

   ```
   php artisan storage:link
   ```

   and enjoy the forum.

#### Contact

If you have any issues about safety or functions, you are welcomed to submit an issue to this repository.