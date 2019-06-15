# 安装

---

- [安装环境依赖](#dependencies)
- [开发环境下的安装](#install-dev)
- [生产环境下的安装](#install-prod)
- [放置闭源文件](#private-files)

<a name="dependencies"></a>
## 安装环境依赖

一台运行JBOnline的服务器/开发机需要以下服务：

- PHP 7.2+
- Node.js 10+
- MariaDB 10+
- Apache/Caddy

> {info} 注意：
>
> - 开发环境下不需要网页服务器。
> - PHP需要以下扩展：BCMath, Ctype, EXIF, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML。
> - 其他要求可参考 [<Laravel官方指南>](https://laravel.com/docs/5.8/installation) 。

<!-- -->

> {success} 妈耶，我没有装过以上任何一个程序，怎么办！
>
> 不用担心，Laravel帮你准备了一套虚拟机！你只需要
>
> - 安装VirturalBox, VMWare, Parallels, Hyper-V任意之一，
> - 然后再安装Vagrant，
>
> 即可轻松获得一套完整的开发环境！hso！具体请见 [<Homestead官方安装指南>](https://laravel.com/docs/5.8/homestead) 。

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

> {success} 生产环境下也可以使用上面开发环境下的方式安装，只不过不使用PHP开发环境的服务器，而是使用Apache/Caddy等网页服务器进行处理。
>
> 实际上更加推荐下面的方法，使用docker进行虚拟化的部署，简单方便易于管理。

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

> {warning} 注意：Caddy容器是基于Alpine的，容器里只有一个啥也不能干的ash，所以最好在容器外编辑配置文件。

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
> 敬告：违反相关授权协议或知识产权相关法律法规是严重的作死行为。

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