# 安装

---

- [安装环境依赖](#dependencies)
- [开发环境下的安装](#install-dev)
- [生产环境下的安装](#install-prod)
- [放置闭源文件](#private-files)

<a name="dependencies"></a>
## 安装环境依赖

一台运行JBOnline的服务器/开发机需要以下环境：

> {info} 开发环境不需要网页服务器。

- PHP 7.2+
- Node.js 10+
- MySQL/MariaDB 10+
- Apache/Caddy
- [Optional] Docker

<a name="install-dev"></a>
## 开发环境下的安装

```shell
Clone the repository first.
$ git clone [REPO] njujb && cd njujb

Install code dependencies.
$ npm install && npm run dev
$ composer install

Prepare Laravel and database.
$ cp .env-example .env && vim .env
$ php artisan migrate
$ php artisan key:generate
$ php artisan storage:link

Start development server.
$ php artisan serve
```

<a name="install-prod"></a>
## 生产环境下的安装

> {success} 生产环境下可以使用上面开发环境下的方式安装，但不使用PHP开发环境服务器，而是使用Apache/Caddy等网页服务器进行处理。
> 但是更加推荐下面的方法，使用docker进行虚拟化的部署。

```shell
Clone the repository first.
$ git clone [REPO] njujb

Prepare Laravel, use `mysql` as the host of database.
$ cd ../njujb
$ cp .env-example .env && vim .env

Install Laradock and prepare webserver.
$ git clone https://github.com/Laradock/laradock.git laradock
$ cd laradock && cp env-example .env && vim .env
$ vim caddy/caddy/Caddyfile
$ docker-compose up -d caddy mariadb workspace

Enter the container and prepare the rest.
$ docker-compose exec workspace bash
$ cd /var/www/njujb
$ npm install && npm run prod
$ composer install
$ php artisan migrate
$ php artisan key:generate
$ php artisan storage:link
```

> {warning} 注意：Caddy容器是基于Alpine的，只有一个sh，所以最好在容器外编辑配置文件。

Laravel的参考Caddyfile：
```caddyfile
https://njujb.com {
    tls admin@njujb.com
    root /var/www/njujb
    log /path/to/log_file
    errors /path/to/err_file
    
    fastcgi / php-fpm:9000 php {
        index index.php
    }
    
    rewrite {
        r .*
        ext /
        to /index.php?{query}
    }
}
```

<a name="private-files"></a>
## 放置闭源文件

将对应的文件拷贝到`/public`目录对应文件夹中。

注意`app.css`和`app.js`是由npm自动生成的，不需要拷贝。

> {warning} 可我没有这些闭源文件怎么办？
>
> 你傻啊 cmlnaHQgY2xpY2sgYW5kIGluc3BlY3Q=
>
> 警告：违反相关授权协议或知识产权相关法律法规是严重的作死行为。

```shell
├─css
│      app.css
│      fontawesome.css
│      purpose.css
│
├─js
│      app.js
│      purpose.core.js
│      purpose.js
│
└─webfonts
        fa-brands-400.eot
        ......
```