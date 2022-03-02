# AuthNode Hyperf

用户Hyperf框架的权限节点注解

### 注解说明

#### IsAuthNode

* `name` 项目中不可重复,可省略填写,将自动获取类名/方法名
* `label` 用于简短介绍该节点用途,供开发和管理人员查看

### 使用方法

需要在全局中间件里添加 `AuthNodeMiddleware`

随后可通过 `$request->getAttribute(CurrentNode::class)` 得到一个数组, 里面是该路由所包含的权限节点列表
