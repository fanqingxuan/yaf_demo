<?php

class Model
{
    protected $primary_key = 'id';
    
    /**
     *
     * @var Medoo
     */
    private $db;
    
    private $where = [];
    private $columns = '*';

    private static $instance = null;

    final public function __construct()
    {
        $this->db = JContainer::getDb();
    }

    private function __clone()
    {
    }

    /**
     * 单例模式
     *
     * @return $this 返回当前对象
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof static)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 返回表名
     *
     * @return string
     */
    public static function tableName()
    {
        $table = self::tableize(str_replace("Model", "", static::class));
        return $table;
    }

    /**
     * Converts a word fomat from 'ModelName' to 'model_name'.
     */
    private static function tableize($word)
    {
        $tableized = preg_replace('~(?<=\\w)([A-Z])~u', '_$1', $word);

        if ($tableized === null) {
            throw new RuntimeException(
                sprintf(
                    'preg_replace returned null for value "%s"',
                    $word
                )
            );
        }

        return mb_strtolower($tableized);
    }

    /**
     * @param  array $where
     * @return mixed 记录数
     * usage:
     * $user = new User;
     * $user->count()
     */
    public function count($where = [])
    {
        return $this->db->count(static::tableName(), $where);
    }
    /**
     * @param  array $where where条件
     * @return $this 返回当前对象
     */
    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    /**
     * @param  array $columns 查询列
     * @return $this 返回当前对象
     */
    public function fields($columns)
    {
        if ($columns != '*' && is_string($columns)) {
            $columns = explode(',', $columns);
        }
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param  array $where
     * @param  array $columns
     * @return mixed 返回一条数据
     * usage:
     * $user = new User;
     * $user->fields(['username','password'])->where(["age"=>34])->get()
     * $user->get(["age"=>34],['username','password'])
     * $user->get(["age"=>34])
     * $user->where(["age"=>34])->get()
     */
    public function get($where = [], $columns = '')
    {
        if (!$columns) {
            $columns = $this->columns;
        }
        if (!$where) {
            $where = $this->where;
        }
        $this->_reset();
        $data = $this->db->get(static::tableName(), $columns, $where);
        return $data?:[];
    }

    /**
     * 查询
     *
     * @param  array $where   查询where
     * @param  array $columns 查询column
     * @return array 返回二位数组结果数组
     * usage:
     * $user = new User;
     * $user->fields(['username','password'])->where(["age"=>34])->all()
     * $user->all(["age"=>34],['username','password'])
     * $user->where(["age"=>34])->all()
     * $user->all(["age"=>34])
     */
    public function all($where = [], $columns = '')
    {
        if (!$columns) {
            $columns = $this->columns;
        }
        if (!$where) {
            $where = $this->where;
        }
        $this->_reset();
        return $this->db->select(static::tableName(), $columns, $where);
    }

    private function _reset()
    {
        $this->columns = '*';
        $this->where = [];
    }

    /**
     * 根据主键删除
     *
     * @param  int|array $ids 主键id
     * @return int  返回受影响的行数
     * usage:
     * $user = new User;
     * $user->deleteByPk('1,2,3')
     * $user->deleteByPk([1,2,3])
     */
    public function deleteByPk($ids)
    {
        return $this->delete([$this->primary_key => is_array($ids)?$ids:explode(',', $ids)]);
    }

    /**
     * 根据条件删除
     *
     * @param  $where 删除的where条件
     * @return int  返回受影响的行数
     * usage:
     * $user = new User;
     * $user->delete(['id'=>4])
     */
    public function delete($where)
    {
        if (empty($where)) {
            throw new Exception("Where cannot empty");
        }
        return $this->db->delete(static::tableName(), $where)->rowCount();
    }

    /**
     * 写入数据
     *
     * @param  array $data 写入的数据
     * @return int 返回insert id
     * usage:
     * $user = new User;
     * $user->insert(['username'=>'json','email'=>'fxj@acewill.cn'])
     */
    public function insert($data)
    {
        $this->db->insert(static::tableName(), $data);
        return $this->db->id();
    }

    /**
     * 根据主键更新数据
     *
     * @param array        $data 要更新的数据
     * @param string|array $ids
     * usage:
     * $user = new User;
     * $user->updateByPk(['username'=>'json','email'=>'fxj@acewill.cn'],'4,5')
     * $user->updateByPk(['username'=>'json','email'=>'fxj@acewill.cn'],[4,5])
     */
    public function updateByPk($data, $ids)
    {
        return $this->update($data, [$this->primary_key => is_array($ids)?$ids:explode(',', $ids)]);
    }

    /**
     * 根据条件更新数据
     *
     * @param array $data  更新的数据
     * @param array $where 更新的where条件
     *                     $return int 返回受影响的行数
     *                     usage:
     *                     $user = new User;
     *                     $user->update(['username'=>'json','email'=>'fxj@acewill.cn'],['username'=>'fxj'])
     */
    public function update($data, $where)
    {
        return $this->db->update(static::tableName(), $data, $where)->rowCount();
    }

    /**
     * 更新或修改，参数数组有主键字段则是更新，否则是删除
     *
     * @param array $data
     * usage:
     * $user = new User;
     * $user->updateOrCreate(['username'=>'json','email'=>'fxj@acewill.cn'])
     * $user->updateOrCreate(['id'=>4,'username'=>'json','email'=>'fxj@acewill.cn'])
     */
    public function updateOrCreate($data)
    {
        if (isset($data[$this->primary_key]) && $data[$this->primary_key]) {
            $pk = $data[$this->primary_key];
            unset($data[$this->primary_key]);
            return $this->updateByPk($data, $pk);
        } else {
            return $this->insert($data);
        }
    }

    public function query($sql, $params = [])
    {
        $_sql = strtoupper(trim($sql));
        if (strpos($_sql, "SELECT") !== 0) {
            throw new Exception("Only support the sql of select,Please check the sql:".$sql);
        }
        return $this->db->query($sql, $params)->fetchAll();
    }

    /**
     * 最后执行的sql语句
     *
     * @return string
     */
    public function getLastSql()
    {
        return $this->db->last();
    }

    /**
     * 获取执行的所有sql
     *
     * @return array
     */
    public function getExecutedSqlList()
    {
        return $this->db->log();
    }

    /**
     * @param  int   $pk      主键
     * @param  array $columns 查询列
     * @return mixed 返回一条数据
     * usage:
     * User::find(3,['username','password'])
     * User::find(3)
     */
    public static function find($pk, $columns ='*')
    {
        $obj = self::getInstance();
        return $obj->fields($columns)->where([$obj->primary_key => $pk])->get();
    }

    /**
     * 查询多条数据
     *
     * @param  string|array $pks     主键
     * @param  array        $columns 查询列
     * @return array 返回二维数组
     * usage:
     * User::findAll([1,2,3],['username','password'])
     * User::findAll('1,2,3',['username','password'])
     * User::findAll('1,2,3')
     * User::findAll([1,2,3])
     */
    public static function findAll($pks = [], $columns='')
    {
        $obj = self::getInstance();
        $pks = is_array($pks)?$pks:explode(',', $pks);
        $where = $pks?[$obj->primary_key => $pks]:[];
        return $obj->all($where, $columns);
    }

    /**
     * 根据条件查询数据
     *
     * @param  array $where
     * @param  array $columns
     * @return array 返回二维数组
     * usage:
     * User::findByCondition(["age"=>34],['username','password'])
     * User::findByCondition(["age"=>34])
     */
    public static function findByCondition($where, $columns='*')
    {
        return self::getInstance()->fields($columns)->where($where)->all();
    }

    /**
     * 原生查询
     *
     *
     * User::select("SELECT * FROM sls_p_user limit 1");
     * User::select("SELECT * FROM sls_p_user where id=:id limit 1",[":id"=>1]);
     */
    public static function select($sql, $params)
    {
        return self::getInstance()->query($sql, $params);
    }

    /**
     * 新增或者修改，存在主键则是修改，否则是新增
     *
     * @param [array] $data
     * @return void
     *
     * User::save(['username'=>'json']);//新增
     * User::save(['username'=>'Json','uid'=>1]);//更改
     */
    public static function save($data)
    {
        return self::getInstance()->updateOrCreate($data);
    }

    /**
     * 新增
     *
     * @param [array] $data
     * @return void

     * User::create(['username'=>'json']);
     */
    public static function create($data)
    {
        return self::getInstance()->insert($data);
    }

    /**
     * 删除
     *
     * User::destroy('1,2,3');
     * User::destroy(1);
     * User::destroy([1,2,3]);
     */
    public static function destroy($pks)
    {
        return self::getInstance()->deleteByPk($pks);
    }
}
