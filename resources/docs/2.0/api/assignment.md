# 作业API

---

- [`GET /api/assignment`](#a-1)
- [`POST /api/assignment`](#a-2)
- [`GET /api/assignment/{id}`](#a-3)
- [`PUT /api/assignment/{id}`](#a-4)
- [`DELETE /api/assignment/{id}`](#a-5)
- [`POST /api/assignment/{id}/finish`](#a-6)
- [`POST /api/assignment/{id}/reset`](#a-7)
- [`POST /api/assignment/{id}/rate`](#a-8)

> {success} 绕过本页面API权限检查的条件：要求 `$user->privilege_level <= 2` 即用户为管理员。

作业模型对应的JSON数据结构：

```json
assignment: {
    content: "Hello, world!",
    content_html: "<p>Hello, world!</p>",
    course_id: 2,
    due_time: "2019-06-20 17:12:06",
    finish_record: {
        assignment_id: 2
        finished_at: "2019-06-16T09:16:46.000000Z"
        user_id: 5
    },
    id: 2,
    name: "testAssignment",
    rate_info: {
        rated: "null",
        stats: {
            like: 2,
            dislike: 3
        }
    }
}
```

<a name="a-1"></a>
## `GET /api/assignment`

- 用途：获取作业列表
- 权限：允许所有用户访问
- 参数：
  ```php
  'show_all'        => ['sometimes', 'required', 'boolean'],
  'course_id'       => ['sometimes', 'required', 'integer', 'exists:courses,id'],
  'due_after'       => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  'due_before'      => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  'unfinished_only' => ['sometimes', 'required', 'boolean'],
  ```
- 说明：
  - 如果没有`show_all`参数，只显示所有用户加入的课程的作业。
- 返回：`200 OK` 符合筛选条件的作业列表

<a name="a-2"></a>
## `POST /api/assignment`

- 用途：新建一个作业
- 权限：只允许注册为对应课程管理员的用户访问
- 参数：
  ```php
  'course_id' => ['required', 'integer', 'exists:courses,id'],
  'name'      => ['required', new Sanitize(), 'max:100'],
  'content'   => ['required', new Sanitize(), 'max:2000'],
  'due_time'  => ['required', 'date_format:Y-m-d H:i:s'],
  ```
- 返回：`201 Created` 新建的作业

<a name="a-3"></a>
## `GET /api/assignment/{id}`

- 用途：查看某个作业
- 权限：允许所有用户访问
- 参数：无
- 返回：`200 OK` ID对应的作业

<a name="a-4"></a>
## `PUT /api/assignment/{id}`

- 用途：修改一个作业
- 权限：只允许注册为对应课程管理员的用户访问
- 参数：
  ```php
  'name'      => ['sometimes', 'required', new Sanitize(), 'max:100'],
  'content'   => ['sometimes', 'required', new Sanitize(), 'max:2000'],
  'due_time'  => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
  ```
- 返回：`200 OK` 更新后的作业

<a name="a-5"></a>
## `DELETE /api/assignment/{id}`

- 用途：删除一个作业
- 权限：只允许注册为对应课程管理员的用户访问
- 参数：无
- 返回：`204 No Content`

<a name="a-6"></a>
## `POST /api/assignment/{id}/finish`

- 用途：标记一个作业为已完成
- 权限：只允许已加入对应课程的用户访问
- 参数：无
- 返回：`200 OK` 作业完成记录
  ```json
  finish_record: {
        assignment_id: 2
        finished_at: "2019-06-16T09:16:46.000000Z"
        user_id: 5
  }
  ```

<a name="a-7"></a>
## `POST /api/assignment/{id}/reset`

- 用途：重置一个作业的完成记录
- 权限：只允许已加入对应课程的用户访问
- 参数：无
- 返回：`204 No Content`

<a name="a-8"></a>
## `POST /api/assignment/{id}/rate`

> {primary} 这个API只能用于更改用户评价，喜欢两次等于撤销喜欢；讨厌两次等于撤销讨厌。
>
> 如果要获取用户当前评价，直接获取对应作业的信息即可。

- 用途：评价一个作业
- 权限：只允许已加入对应课程的用户访问
- 参数：
  ```php
  'like' => ['required', 'boolean'],
  ```
- 返回：`200 OK` 更新后的评价信息
  ```json
  rate_info: {
        rated: "null/like/dislike",
        stats: {
            like: 5,
            dislike: 10
        }
  }
  ```