# 欢迎来到JBOnline的开发手册！

---

- [JBOnline是什么](#what-is-jb-online)
- [开源组件](#open-source)
- [闭源组件](#private-source)

<a name="what-is-jb-online"></a>
## JBOnline是什么

> {primary} JBOnline不是跷课宝。

JBOnline是一款可以记录作业内容和完成情况、同时支持文件共享、博客聚合等功能的网站系统。

JBOnline基于Laravel 5.8开发，所以Laravel相关的结构、函数的帮助都可以在 [<官方文档>](https://laravel.com/docs/5.8) 上找到。

<a name="open-source"></a>
## 开源组件

### Laravel Family

- Laravel Framework 5.8
- Laravel Telescope

### PHP

- binarytorch/larecipe
- cybercog/laravel-love (v5)
- erusev/parsedown
- mews/purifier
- willvincent/feeds

### JavaScript

- jQuery
- Vue 2
- Axios
- laravel-mix
- lodash
- popper
- katex
- craftpip/jquery-confirm
- iamkun/dayjs
- vuejs-tips/vue-the-mask

<a name="private-source"></a>
## 闭源组件

> {primary} 注意：闭源代码不会也不应该出现在任何的公开代码仓库中，因此在开发环境下的显示效果可能和生产环境不同。
> 通过使用对应的开源版本可以尽可能地减小差异。具体内容请见<安装>部分。

- FontAwesome5：可使用FA5的开源版本代替，部分图标会受到影响；
- Purpose2：可使用Bootstrap4.3+公开版代替，部分界面UI会受到影响。