# API综述

--- 

- [认证](#authentication)
- [动词](#verbal)
- [返回值](#return-value)

> {primary} JBOnline的API世界第一！（误）

<a name="authentication"></a>
## 认证

API的认证方法有两种：

- 对于Web请求，使用XSRF密钥进行认证（Axios在页面加载时已经默认配置了XSRF请求头，直接调用`window.axios`即可）；
- 对于其他请求，需要从OAuth2服务器获取访问token然后使用`Bearer token`的请求头认证，对应的认证方法请查看OAuth2的手册。

> {info} OAuth2对第一方客户端和第三方客户端有不同的认证方式，等网页开发完成后我们会在用户页面内制作OAuth第三方客户端的注册和管理模块。

<a name="verbal"></a>
## 动词

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