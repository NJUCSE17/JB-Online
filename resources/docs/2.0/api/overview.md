# API综述

--- 

- [用户认证](#authentication)
- [权限检查](#privilege)
- [请求动词](#verbal)
- [返回值](#return-value)
- [使用示例](#example)

> {primary} JBOnline的API世界第一！（误）

<a name="authentication"></a>
## 用户认证

所有的API访问必须经过`auth`中间件检查。如果请求没有有效的用户认证，将会以`401 Unauthorized`错误拒绝。

API的用户认证方法有两种：

- 对于Web请求，使用XSRF密钥进行认证（Axios在页面加载时已经默认配置了XSRF请求头，直接调用`window.axios`即可）；
- 对于其他请求，需要从OAuth2服务器获取访问token然后使用`Bearer token`的请求头认证，对应的认证方法请查看OAuth2的手册。

> {info} OAuth2对第一方客户端和第三方客户端有不同的认证方式，等网页开发完成后我们会在用户页面内制作OAuth第三方客户端的注册和管理模块。

<a name="privilege"></a>
## 权限检查

服务器收到请求后会对用户的权限、请求的内容进行检查：

- 用户权限不足以进行对应的请求，返回`401 Unauthorized`；
- 请求的内容存在非法或不满足要求（例如输入了9102年），返回`422 Unprocessable Entity`。

> {success} 绕过权限检查：
>
> 不同的API会有不同的权限条件。但是对于所有的API，在进行具体的权限检查前会对用户进行预先检查。
>
> - 用户未认证或未获管理员使用许可，直接拒绝请求。
> - 用户为管理员或其他特殊身份，则跳过后面的检查，具体要求见各个API页面。

<a name="verbal"></a>
## 请求动词

JBOnline的API采用（几乎）标准的CRUD动词：

- GET：获取资源
- POST：新建资源
- PUT：更新资源
- DELETE：删除资源

<a name="return-value"></a>
## 返回值

API返回的HTTP状态可能有：

- 200 OK
- 201 Created
- 40X/50X Error

当返回200/201时，同时会返回一份JSON格式的对应资源。

发生错误时，会返回对应错误的信息(message)。

<a name="example"></a>
## 使用示例

在Edge的开发者控制台中直接使用API请求获取当前用户信息：

```javascript
> window.axios.get("/api/user/1").then(res=>{console.log(res);});

< Promise {<pending>}
< {data: {…}, status: 200, statusText: "", headers: {…}, config: {…}, …}
```

请求成功，返回状态为200，数据中的`data`为JSON格式，读取如下：

```json
data: {
    active: true,
    blog_feed_url: null,
    email: "alice@utopia.com",
    id: 1,
    name: "测试账户",
    student_id: 170000001,
}
```

如果请求出错或者资源未找到，则会产生错误，可使用`.catch`进行异常处理。

```javascript
> window.axios.get("/api/user/2").catch(err=>{console.log(err);});

< Promise {<pending>}
X GET https://dev.njujb.com/api/user/2 404
< Error: Request failed with status code 404
```