### 环境要求
- yaf版本3.2.5
- php版本7.0+

### 说明
该项目使用yaf搭建的一个开箱即用的web api项目
- 集成了seaslog高性能日志组件，记录日志，日志分业务日志，error日志以及request日志
- 集成了phpredis类库，封装成JRedis，方便使用redis，也可以提取出来用到自己的项目里面，这个类库基本包含了phpredis的所有函数，便于编辑器提示
- 集成了Medoo作为数据库连接层，同时做简单封装到BaseModel里面，便于业务model做快速的增删改查
- 目录结构
  - controllers  控制器目录
  - models 做数据库的查询
  - services 做为业务处理层
  - config 配置层
  - logs 日志目录，里面有default子目录作为业务日志，error子目录错误日志，request子目录做请求日志，日志按天分隔文件
  - libs 类库目录
  - plugins 中间件钩子目录