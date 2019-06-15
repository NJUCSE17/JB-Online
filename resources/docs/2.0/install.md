# 安装

---

- [安装环境依赖](#dependencies)
- [开发环境下的安装](#install-dev)
- [生产环境下的安装](#install-prod)

<a id="dependencies"></a>
## 安装环境依赖

一台运行JBOnline的服务器/开发机需要以下环境：

> {info} 开发环境不需要网页服务器。

- PHP 7.2+
- Node.js 10+
- MySQL/MariaDB 10+
- Apache/Caddy
- [Optional] Docker

<a id="install-dev"></a>
## 开发环境下的安装

```shell
Clone the repository first.
$ git clone [REPO] njujb && cd njujb

Install code dependencies.
$ npm install
$ composer install

Prepare Laravel and database.
$ cp .env-example .env && vim .env
$ php artisan migrate
$ php artisan key:generate
$ php artisan storage:link

Start development server.
$ php artisan serve
```

<a id="install-prod"></a>
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
$ npm install
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