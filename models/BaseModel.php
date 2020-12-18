<?php

class BaseModel {

    protected $primary_key = 'id';
    protected $db;
    private $where = [];
    private $columns = '*';

    final public function __construct() {
        $this->db = Yaf_Registry::get('db');
    }

    /**
     * 返回表名
     * @return string
     */
    public static function tableName()
    {
        $table = self::tableize(str_replace("Model","",static::class));
        return $table;
    }

    /**
     * Converts a word into the format for a Doctrine table name. Converts 'ModelName' to 'model_name'.
     */
    private static function tableize( $word)
    {
        $tableized = preg_replace('~(?<=\\w)([A-Z])~u', '_$1', $word);

        if ($tableized === null) {
            throw new RuntimeException(sprintf(
                'preg_replace returned null for value "%s"',
                $word
            ));
        }

        return mb_strtolower($tableized);
    }

    /**
     * @param int $pk 主键
     * @param array $columns 查询列
     * @return mixed 返回一条数据
     * usage:
     * $user = new User;
     * $user->findByPk(3,['username','password'])
     * $user->findByPk(3)
     */
    public function findByPk($pk,$columns ='*')
    {
    	return $this->fields($columns)->where([$this->primary_key => $pk])->get();
    }

    /**
     * 根据主键查询数据
     * @param string|array $pks 主键
     * @param array $columns 查询列
     * @return array 返回二维数组
     * usage:
     * $user = new User;
     * $user->findAll([1,2,3],['username','password'])
     * $user->findAll('1,2,3',['username','password'])
     * $user->findAll('1,2,3')
     * $user->findAll([1,2,3])
     */
    public function findAll($pks = [],$columns='*')
    {
        $pks = is_array($pks)?$pks:explode(',',$pks);
        $where = $pks?[$this->primary_key => $pks]:[];
        return $this->fields($columns)->where($where)->all();
    }

    /**
     * 根据条件查询数据
     * @param array $where
     * @param array $columns
     * @return array 返回二维数组
     * usage:
     * $user = new User;
     * $user->findByCondition(["age"=>34],['username','password'])
     * $user->findByCondition(["age"=>34])
     */
    public function findByCondition($where,$columns='*')
    {
        return $this->fields($columns)->where($where)->all();
    }

    /**
     * @param array $where
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
     * @param array $where where条件
     * @return $this 返回当前对象
     */
    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    /**
     * @param array $columns 查询列
     * @return $this 返回当前对象
     */
    public function fields($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param array $where
     * @param array $columns
     * @return mixed 返回一条数据
     * usage:
     * $user = new User;
     * $user->fields(['username','password'])->where(["age"=>34])->get()
     * $user->get(["age"=>34],['username','password'])
     * $user->get(["age"=>34])
     * $user->where(["age"=>34])->get()
     */
    public function get($where = [],$columns = '')
    {
        if(!$columns) {
            $columns = $this->columns;
        }
        if(!$where) {
            $where = $this->where;
        }
        $this->_reset();
        $data = $this->db->get(static::tableName(),$columns,$where);
        return $data?:[];
    }

    /**
     * 查询
     * @param array $where 查询where
     * @param array $columns 查询column
     * @return array 返回二位数组结果数组
     * usage:
     * $user = new User;
     * $user->fields(['username','password'])->where(["age"=>34])->all()
     * $user->all(["age"=>34],['username','password'])
     * $user->where(["age"=>34])->all()
     * $user->all(["age"=>34])
     */
    public function all($where = [],$columns = '')
    {
        if(!$columns) {
            $columns = $this->columns;
        }
        if(!$where) {
            $where = $this->where;
        }
        $this->_reset();
        return $this->db->select(static::tableName(),$columns,$where);
    }

    private function _reset()
    {
        $this->columns = '*';
        $this->where = [];
    }

    /**
     * 根据主键删除
     * @param int|array $ids 主键id
     * @return int  返回受影响的行数
     * usage:
     * $user = new User;
     * $user->deleteByPk('1,2,3')
     * $user->deleteByPk([1,2,3])
     */
    public function deleteByPk($ids)
    {
        return $this->delete([$this->primary_key => is_array($ids)?$ids:explode(',',$ids)]);
    }

    /**
     * 根据条件删除
     * @param $where 删除的where条件
     * @return int  返回受影响的行数
     * usage:
     * $user = new User;
     * $user->delete(['id'=>4])
     */
    public function delete($where)
    {
        if(empty($where)) {
            throw new Exception("Where cannot empty");
        }
        return $this->db->delete(static::tableName(),$where)->rowCount();
    }

    /**
     * 写入数据
     * @param array $data 写入的数据
     * @return int 返回insert id
     * usage:
     * $user = new User;
     * $user->create(['username'=>'json','email'=>'fxj@acewill.cn'])
     */
    public function create($data)
    {
        $this->db->insert(static::tableName(),$data);
        return $this->db->id();
    }

    /**
     * 根据主键更新数据
     * @param array $data 要更新的数据
     * @param string|array $ids
     * usage:
     * $user = new User;
     * $user->updateByPk(['username'=>'json','email'=>'fxj@acewill.cn'],'4,5')
     * $user->updateByPk(['username'=>'json','email'=>'fxj@acewill.cn'],[4,5])
     */
    public function updateByPk($data,$ids)
    {
        return $this->update($data,[$this->primary_key => is_array($ids)?$ids:explode(',',$ids)]);
    }

    /**
     * 根据条件更新数据
     * @param array $data 更新的数据
     * @param array $where 更新的where条件
     * $return int 返回受影响的行数
     * usage:
     * $user = new User;
     * $user->update(['username'=>'json','email'=>'fxj@acewill.cn'],['username'=>'fxj'])
     */
    public function update($data,$where)
    {
        return $this->db->update(static::tableName(),$data,$where)->rowCount();
    }

    /**
     * 更新或修改，参数数组有主键字段则是更新，否则是删除
     * @param array $data
     * usage:
     * $user = new User;
     * $user->updateOrCreate(['username'=>'json','email'=>'fxj@acewill.cn'])
     * $user->updateOrCreate(['id'=>4,'username'=>'json','email'=>'fxj@acewill.cn'])
     */
    public function updateOrCreate($data)
    {
        if(isset($data[$this->primary_key]) && $data[$this->primary_key]) {
            $pk = $data[$this->primary_key];
            unset($data[$this->primary_key]);
            return $this->updateByPk($data,$pk);
        } else {
            return $this->create($data);
        }
    }

    public function query($sql) {
        $_sql = strtoupper(trim($sql));
        if(strpos($_sql,"SELECT") !== 0 ) {
            throw new Exception("Only support the sql of select");
        }
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * 最后执行的sql语句
     * @return string
     */
    public function getLastSql()
    {
        return $this->db->last();
    }

    /**
     * 获取执行的所有sql
     * @return array
     */
    public function getExecutedSqlList() {
        return $this->db->log();
    }

}
