# 个人作业API

---

- [`GET /api/personalAssignment`](#pa-1)
- [`POST /api/personalAssignment`](#pa-2)
- [`GET /api/personalAssignment/{id}`](#pa-3)
- [`PUT /api/personalAssignment/{id}`](#pa-4)
- [`DELETE /api/personalAssignment/{id}`](#pa-5)
- [`POST /api/personalAssignment/{id}/finish`](#pa-6)
- [`POST /api/personalAssignment/{id}/reset`](#pa-7)

> {success} 绕过本页面API权限检查的条件：
>
> 除 `finish` 和 `reset` 不得绕过以外，要求 `$user->privilege_level <= 2` 即用户为管理员。

个人作业模型对应的JSON数据结构：

```json
personalAssignment: {
    content: "example",
    content_html: "<p>example</p>",
    due_time: "2019-09-01 11:45:14",
    finished_at: "2019-06-16T09:16:46.000000Z",
    id: 1,
    is_ongoing: false,
    name: "Test Example",
    user_id: 1
}
```

<a name="pa-1"></a>
## `GET /api/personalAssignment`

- 用途：获取个人作业列表
- 权限：允许所有用户访问，但部分参数有使用限制（见说明）
- 参数：
  ```php
  'show_all'        => ['sometimes', 'required', 'boolean'],
  'user_id'         => ['sometimes', 'required', 'integer', 'exists:users,id'],
  'due_after'       => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  'due_before'      => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  'unfinished_only' => ['sometimes', 'required', 'boolean'],
  ```
- 返回：`200 OK` 符合筛选条件的作业列表
- 说明：当`show_all`或`user_id`参数存在（不论是否为当前用户ID）时，用户必须为管理员即`$user->privilege_level <= 2`。

<a name="pa-2"></a>
## `POST /api/personalAssignment`

- 用途：新建一个个人作业
- 权限：允许所有用户访问
- 参数：
  ```php
  'name'     => ['required', new Sanitize(), 'max:100'],
  'content'  => ['required', new Sanitize(), 'max:2000'],
  'due_time' => ['required', 'date_format:Y-m-d H:i:s'],
  ```
- 返回：`201 Created` 新建作业的数据

<a name="pa-3"></a>
## `GET /api/personalAssignment/{id}`

- 用途：获取指定的个人作业
- 权限：只允许用户访问自己的作业
- 参数：无
- 返回：`200 OK` ID指定的作业

<a name="pa-4"></a>
## `PUT /api/personalAssignment/{id}`

- 用途：修改一个个人作业
- 权限：只允许用户访问自己的作业
- 参数：
  ```php
  'name'     => ['sometimes', 'required', new Sanitize(), 'max:100'],
  'content'  => ['sometimes', 'required', new Sanitize(), 'max:2000'],
  'due_time' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  ```
- 返回：`200 OK` 更新后的作业

<a name="pa-5"></a>
## `DELETE /api/personalAssignment/{id}`

- 用途：删除一个个人作业
- 权限：只允许用户访问自己的作业
- 参数：无
- 返回：`204 No Content`

<a name="pa-6"></a>
## `POST /api/personalAssignment/{id}/finish`

> {warning} 注意：这个API无法绕过权限检查。

- 用途：标记一个个人作业为已完成/进行中，若`ongoing`为`true`，则表示正在进行中，`finished_at`为`NULL`。
- 权限：只允许用户访问自己的作业
- 参数：
  ```php
  'ongoing' => ['boolean'],
  ```
- 返回：`200 OK` 更新后的作业

<a name="pa-7"></a>
## `POST /api/personalAssignment/{id}/reset`

> {warning} 注意：这个API无法绕过权限检查。

- 用途：重置一个个人作业的完成情况
- 权限：只允许用户访问自己的作业
- 参数：无
- 返回：`200 OK` 更新后的作业
