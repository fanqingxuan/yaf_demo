### 环境要求
- php版本7.1+
- yaf扩展3.2.5
- Seaslog扩展
- phpredis扩展(需要使用redis的话)
- pda/pheanstalk高性能任务队列


### 框架说明
该项目使用yaf搭建的一个开箱即用的web api项目
- 集成了seaslog高性能日志组件，用来记录业务日志，error日志以及request日志
- 集成了phpredis类库，封装成JRedis，方便使用redis，也可以提取出来用到自己的项目里面，这个类库包含了phpredis的所有函数，便于编辑器智能提示
- 集成了Medoo作为数据库连接层，在BaseModel里面进行了简单封装，便于业务model做快速的增删改查
- dev-tools目录提供了代码命名规范工具**phpmd**、psr代码美化工具**php-cs-fixer**、代码格式化工具**phpcbf**以及语法错误检查工具**phpcs**、**phpstan**
- 目录结构
  - controllers  控制器目录
  - models 做数据库的查询
  - services 做为业务处理层
  - config 配置项目录，包括db、redis、日志等配置
  - logs 日志目录，里面有default子目录作为业务日志，error子目录错误日志，request子目录做请求日志，日志按天生成文件
  - libs 类库目录
  - plugins 中间件钩子目录

### model

model默认使用model类去掉Model后由驼峰式转成长蛇格式后的字符串作为表名字，例如UserModel表名称是user，UserPostModel用user_post作为表名称，也支持自定义表名称，在model里面定义tableName静态方法，如下:

```php
<?php

class UserModel extends BaseModel
{
    protected $primary_key = 'uid';

    public static function tableName()
    {
        return 't_user';
    }
}
```

默认用id字段作为主键，可以用`$primary_key`属性自定义表主键，便于下面根据主键查询时使用。

- 添加

  ```php
  $model = new PostModel;
  $post = [
      'user_id'   =>  11,
      'content'   =>  '这是内容',
      'title'     =>  '这是标题',
  ];
  $id = $model->create($post);
  ```

- 删除

  ```php
  $model = new PostModel;
  $deleteCount = $model->deleteByPk('1,2,3');//pk是字符串
  $deleteCount = $model->deleteByPk([1,2,3]);//pk是数组
  $deleteCount = $model->delete(['id'=>[1,2,3]]);//根据where条件删除
  ```

- 修改

  ```php
  $model = new PostModel;
  $data = [
      'content'   =>  'this is 444',
  ];
  $affectRows = $model->updateByPk($data,'10,11,12');//pk是字符串
  $affectRows = $model->updateByPk($data,[10,11]);//pk是数组
  
  $where = ['id'=>10];
  $affectRows = $model->update($data,$where);//根据where条件修改
  ```

- 查询单条数据

  ```php
  $data = $model->fields(['title','content'])->where(['id'=>10])->get();//查询字段是数组
  $data = $model->fields('title,content')->where(['id'=>10])->get();//查询字段是字符串
  
  $where = ['id'=>10];
  $data = $model->get($where);//查询所有字段
  
  $where = ['id'=>10];
  $fields = ['title','content'];
  $data = $model->get($where,$fields);//查询部分字段
  
  $data = $model->findByPk(10);//查询所有字段
  $data = $model->findByPk(10,'title,content');//查询部分字段
  $data = $model->findByPk(10,['title','content']);//查询部分字段
  ```

- 查询多条数据

  ```php
  $data = $model->fields(['title','content'])->where(['id'=>10])->all();//查询字段是数组
  $data = $model->fields('title,content')->where(['id'=>10])->all();//查询字段是字符串
  
  $where = ['id'=>10];
  $data = $model->all($where);//查询所有字段
  
  $where = ['id'=>10];
  $fields = ['title','content'];
  $data = $model->all($where,$fields);//查询部分字段
  
  $data = $model->findAll();//查询所有数据
  
  $pks = [1,2,3];
  $fields = ['title','content'];
  $data = $model->findAll($pks,$fields);
  
  //根据where条件查找
  $where = ['id'=>[4,5]];
  $fields = ['title','content'];
  $data = $model->findByCondition($where,$fields);
  ```

- 其它

  ```php
  $data = [
      'id'        =>  10,//主键
      'content'   =>  'add'
  ];
  $result = $model->updateOrCreate($data);//更改id是10的记录
  
  $data = [
      'content'   =>  'add'
  ];
  $result = $model->updateOrCreate($data);//没有主键，表示新增
  
  $model->getLastSql();//获取最后执行的sql语句
  
  //进行复杂的查询
  $model->query("SELECT u.* from post p join user u on p.uid=u.uid ");
  ```

### 日志

支持debug,info,warn,error,emergency五种级别的日志记录，日志文件会记录在logs目录的default目录下面，对应的日志方法如下:

```php
Logger::debug($keywords,$message);
Logger::info($keywords,$message);
Logger::warn($keywords,$message);
Logger::error($keywords,$message);
Logger::emergency($keywords,$message);
```

可以在config配置文件里面用配置项logging.level配置需要记录的日志级别

日志格式
```shell
时间 | 日志级别 | 进程ID | 请求唯一戳 | 毫秒格式时间戳 | 日志关键字 | 日志内容
```
如下
```shell
2020-12-25 08:55:30 | DEBUG | 40524 | 5fe53882aa1a3 | 1608857730.736 | debug keywords | this is debug message
2020-12-25 08:55:30 | INFO | 40524 | 5fe53882aa1a3 | 1608857730.737 | info keywords | this is info message
2020-12-25 08:55:30 | WARNING | 40524 | 5fe53882aa1a3 | 1608857730.737 | warn keywords | this is warn message
2020-12-25 08:55:30 | ERROR | 40524 | 5fe53882aa1a3 | 1608857730.737 | error keywords | this is error message
2020-12-25 08:55:30 | EMERGENCY | 40524 | 5fe53882aa1a3 | 1608857730.737 | emergency keywords | this is emergency message

```
### 配置项说明

- 配置文件里面支持redis配置

  ```shell
  ;redis配置
  redis.host = 127.0.0.1
  redis.port = 6379
  ;key前缀
  redis.prefix = yaf: 
  redis.dbIndex = 0
  ```

- 是否开启调试模式(开启调试模式，错误信息会直接打印到页面上)

  ```SHEL
  application.debug = On
  ```

- 默认控制器

  ```shel
  application.dispatcher.defaultController = Home
  ```

- 默认action

  ```php
  application.dispatcher.defaultAction = index
  ```
- 默认action

  ```php
  application.dispatcher.defaultAction = index
  ```
- 日志级别
	```
	;debug,info,warn,error,emergency
	logging.level = error
	```

  