# 用户API

---

- [`GET /api/user`](#u-1)
- [`GET /api/user/{id}`](#u-2)
- [`PUT /api/user/{id}`](#u-3)
- [`POST /api/user/{id}/activate`](#u-4)
- [`POST /api/user/{id}/deactivate`](#u-5)

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
    privilege_level: 3,
    student_id: 170000001
}
```

<a name="u-1"></a>
## `GET /api/user`

- 用途：获取用户列表
- 权限：允许所有用户访问
- 参数：
  ```php
  'self' => ['sometimes', 'required', 'boolean'],
  ```
- 说明：`self`参数存在时只返回用户自己的信息，不存在时返回所有用户组成的数组。
- 返回：`200 OK` 所有用户的列表

<a name="u-2"></a>
## `GET /api/user/{id}`

- 用途：获取单个用户信息
- 权限：允许所有用户访问
- 参数：无
- 返回：`200 OK` 对应用户的信息

<a name="u-3"></a>
## `PUT /api/user/{id}`

- 用途：修改单个用户信息
- 权限：只允许用户访问自己的对应API
- 参数：
  ```php
  'name'          => ['sometimes', 'required', 'string', 'max:255'],
  'email'         => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
  'blog_feed_url' => ['sometimes', 'nullable', 'string', 'url', 'max:255', Rule::unique('users')->ignore($user->id)],
  'password'      => ['sometimes', 'required', 'string', 'min:8'],
  'new_password'  => ['sometimes', 'required', 'string', 'min:8'],
  ```
- 说明：
  - 非超级管理员访问时，需要提供用户当前的`password`进行身份验证，若密码不正确返回`403 Forbidden`；
  - 超级管理员访问则无需提供用户旧密码，可以直接修改任何用户的信息。
- 返回：`200 OK` 修改后的用户信息

<a name="u-4"></a>
## `POST /api/user/{id}/activate`

- 用途：启用某个用户
- 权限：不允许访问
- 参数：无
- 返回：`200 OK` 用户更新后的信息

<a name="u-5"></a>
## `POST /api/user/{id}/deactivate`

- 用途：禁用某个用户
- 权限：不允许访问
- 参数：无
- 返回：`200 OK` 用户更新后的信息