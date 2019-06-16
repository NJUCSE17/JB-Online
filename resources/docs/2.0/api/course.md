# 课程API

---

- [`GET /api/course`](#c-1)
- [`POST /api/course`](#c-2)
- [`GET /api/course/{id}`](#c-3)
- [`PUT /api/course/{id}`](#c-4)
- [`DELETE /api/course/{id}`](#c-5)
- [`POST /api/course/{id}/enroll`](#c-6)
- [`POST /api/course/{id}/quit`](#c-7)

> {success} 绕过本页面API权限检查的条件：`$user->privilege_level <= 2` 即用户为管理员。

课程模型对应的JSON数据结构：

```json
course: {
    end_time: "2019-07-16 23:59:59",
    enroll_records: [
        {
            type_is_admin: 0,
            user_id: 1
        },
        ...
    ],
    id: 1,
    name: "ExampleCourse",
    notice: "Example",
    notice_html: "<p>Example</p>",
    semester: 4,
    start_time: "2019-06-16 00:00:00"
}
```

<a name="c-1"></a>
## `GET /api/course`

- 用途：获取课程列表
- 权限：允许所有用户访问
- 参数：
  ```php
  'semester'     => ['sometimes', 'required', 'integer', 'between:1,20'],
  'start_before' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  'end_after'    => ['required_with:start_before', 'date_format:Y-m-d H:i:s', 'after_or_equal:start_before'],
  ```
- 返回：`200 OK` 符合条件的课程列表

<a name="c-2"></a>
## `POST /api/course`

- 用途：新建一个课程
- 权限：不允许访问
- 参数：
  ```php
  'name'       => ['required', new Sanitize(), 'max:200'],
  'semester'   => ['required', 'integer', 'between:1,20'],
  'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
  'end_time'   => ['required', 'date_format:Y-m-d H:i:s', 'after_or_equal:start_before'],
  'notice'     => ['sometimes', 'required', new Sanitize(), 'max:10000'],
  ```
- 返回：`201 Created` 新建的课程

<a name="c-3"></a>
## `GET /api/course/{id}`

- 用途：查看一个课程
- 权限：允许所有用户访问
- 参数：无
- 返回：`200 OK` ID对应的课程

<a name="c-4"></a>
## `PUT /api/course/{id}`

- 用途：修改一个课程
- 权限：只允许注册为该课程管理员的用户访问
- 参数：
  ```php
  'name'       => ['sometimes', 'required', new Sanitize(), 'max:200'],
  'semester'   => ['sometimes', 'required', 'integer', 'between:1,20'],
  'start_time' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  'end_time'   => ['sometimes', 'required', 'date_format:Y-m-d H:i:s', 'after_or_equal:start_before'],
  'notice'     => ['sometimes', 'required', new Sanitize(), 'max:10000'],
  ```
- 返回：`200 OK` 更新后的课程

<a name="c-5"></a>
## `DELETE /api/course/{id}`

- 用途：删除一个课程
- 权限：不允许访问
- 参数：无
- 返回：`204 No Content`

<a name="c-6"></a>
## `POST /api/course/{id}/enroll`

> {primary} 这个API会进行 `updateOrCreate` 的操作。例如，用户已经注册为某课程的学生，要想将用户注册为管理员只需要重新 `enroll` 即可。

- 用途：加入一个课程，或者修改已经加入课程的用户的属性
- 权限：允许所有用户访问，但使用参数有限制
- 参数：
  ```php
  'user_id'       => ['sometimes', 'required', 'integer', 'exists:users,id'],
  'type_is_admin' => ['sometimes', 'boolean'],
  ```
- 说明：
  - 当`user_id`不存在时，表示对当前用户执行加入某个课程的操作。
  - 但任意一个参数存在时，本API权限变更为更新课程所需权限，即要求用户已注册为课程管理员。
- 返回：`200 OK` 加入课程的记录
  ```json
  enroll_record: {
        type_is_admin: 0,
        user_id: 1
  }
  ```

<a name="c-7"></a>
## `POST /api/course/{id}/quit`

> {primary} 这个API会进行 `$query->delete` 的操作。如果用户并没有加入课程，可能会导致 `404 Not Found`。

- 用途：退出一个课程
- 权限：允许所有用户访问，但使用参数有限制
- 参数：
  ```php
  'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
  ```
- 说明：
  - 没有参数时，表示对当前用户执行退出课程的操作。
  - 当参数存在时，本API权限变更为更新课程所需权限，即要求用户已注册为课程管理员。
- 返回：`204 No Content`