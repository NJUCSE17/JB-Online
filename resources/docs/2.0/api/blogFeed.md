# 博客API

---

- [`Get /api/blogFeed`](#b-1)
- [`Get /api/blogFeed/{id}`](#b-2)
- [`Get /api/blogFeed/xml`](#b-3)

> {success} 本页所列API无参数、无权限限制。

数据格式：
```json
blog_feed: {
    content_html: "<h2>Hello, world!</h2>..."
    id: 1
    permalink: "https://yout-site.com/blog/1/"
    published_at: "2019-06-12 15:23:00"
    title: "Hello, world!"
    user_id: 5
    user_name: "Alice"
}
```

<a name="b-1"></a>
## `GET /api/blogFeed/xml`

- 用途：获取博客列表
- 返回：`200 OK` 博客列表

<a name="b-2"></a>
## `GET /api/blogFeed/{id}`

- 用途：获取某一篇博客
- 返回：`200 OK` 对应博客的数据

<a name="b-3"></a>
## `GET /api/blogFeed/xml`

- 用途：获取聚合后的博客RSS/Feed
- 返回：`200 OK + XML` W3C Atom格式的博客文件