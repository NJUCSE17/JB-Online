# 用户API

---

- [`Get /api/user`](#u-1)
- [`GET /api/user/{user}`](#u-2)
- [`PUT /api/user/{user}`](#u-3)
- [`POST /api/user/{user}/activate`](#u-4)
- [`POST /api/user/{user}/deactivate`](#u-5)

> {success} 绕过本页面API权限检查的条件：`$user->privilege_level <= 1` 即用户为超级管理员。

用户模型对应的JSON数据结构：

```json
user: {
    blog_feed_url: null,
    email: "alice@utopia.com",
    id: 1,
    is_active: true,
    is_verified: true,
    name: "Alice",
    student_id: 170000001
}
```

<a name="u-1"></a>
## `GET /api/user`

- 用途：获取用户列表
- 权限：允许所有用户访问
- 参数：无
- 返回：所有用户的列表

<a name="u-2"></a>
## `GET /api/user/{user}`

- 用途：获取单个用户信息
- 权限：允许所有用户访问
- 参数：无
- 返回：对应用户的信息
- 错误：用户不存在时，返回404

<a name="u-3"></a>
## `PUT /api/user/{user}`

- 用途：修改单个用户信息
- 权限：只允许用户访问自己的对应API
- 参数：
  ```php
  'name'          => ['sometimes', 'required', 'string', 'max:255'],
  'email'         => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:users'],
  'blog_feed_url' => ['sometimes', 'required', 'string', 'url', 'max:255', 'unique:users'],
  'password'      => ['sometimes', 'required', 'string', 'min:8'],
  ```
- 返回：修改后的用户信息
- 错误：用户不存在时，返回404

<a name="u-4"></a>
## `POST /api/user/{user}/activate`

- 用途：启用某个用户
- 权限：不允许访问
- 参数：无
- 返回：用户更新后的信息
- 错误：用户不存在时，返回404

<a name="u-5"></a>
## `POST /api/user/{user}/deactivate`

- 用途：禁用某个用户
- 权限：不允许访问
- 参数：无
- 返回：用户更新后的信息
- 错误：用户不存在时，返回404