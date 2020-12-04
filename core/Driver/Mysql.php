<?php
declare(strict_types=1);
namespace Core\Driver;
use PDO;
use PDOException;

class Mysql
{
    /**
     * @author    Alex-黑白
     * @param QQ  392999164
     * @return    'call back white and white back--'
     */

    private static ?Mysql $instance = null;//连接实例 如果有多数据库操作的场景请自行把$instance $conn扩展为数组使用，根据需要实例化对应连接即可(即多例模式)
    public static PDO $conn;//连接句柄
    private static array $config = [//数据库配置 如有临时配置的需求,请自行扩展getInstance参数传入临时config并merge进行配置
        'driver' => 'mysql',
        'host'   => 'localhost',
        'dbname' => 'test',
        'user'   => 'root',
        'pass'   => 'xxxx.'
    ];

    private function __construct()
    {
        if(!class_exists('PDO')) throw new PDOException('you may need mysql_pdo extend !');
        try{
            $dsn = self::$config['driver'].':host='.self::$config['host'].';dbname='.self::$config['dbname'];
            self::$conn = new PDO($dsn, self::$config['user'], self::$config['pass']);
        }catch (PDOException $e) {
            echo $e->getMessage();die;
        }
    }

    /**
     * 获取连接实例
     * @return object $instance
     */
    public static function getInstance()
    {
        if(!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 查询数据
     * @param  string $sql       查询的sql语句
     * @param  array  $bindParam 预处理的绑定参数
     * @return array
     */
    public function select(string $sql, array $bindParam = [])
    {
        $sth = self::$conn->prepare($sql);
        $sth = self::bindParam($sth, $bindParam);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 更新数据
     * @param  string $sql 更新语句
     * @param  array  $bindParam 预处理的绑定参数
     * @return int    受影响的行数
     */
    public function update(string $sql, array $bindParam = [])
    {
        $sth = self::$conn->prepare($sql);
        $sth = self::bindParam($sth, $bindParam);
        $sth->execute();
        return $sth->rowCount();
    }

    /**
     * 插入数据
     * @param  string $table    待插入的表名
     * @param  array  $data     待插入的数组
     * @return int    $rowCount 影响的行数
     */
    public function insert(string $table, array $data)
    {

        if(empty($data) || !is_array($data)) {
            echo __FUNCTION__.' param 2 need not empty array!';die;
        }
        $sql = 'INSERT INTO '.$table;
        $flag = 1;
        $len = count($data);
        $params = '';
        $values = '';
        $bindParam = [];
        
        if($len == count($data, 1)) {//插入单行
            if($len == 1) {//单行一个字段
                foreach($data as $k=>$v) {
                    $params .= '('.$k.')';
                    $values .= '(?)';
                    array_push($bindParam, $data[$k]);
                }
            }else {//单行多字段
                foreach($data as $k=>$v) {
                    if($flag == 1) {
                        $params .= '('.$k.',';
                        $values .= '(?,';
                        array_push($bindParam, $data[$k]);
                    }elseif($flag == $len) {
                        $params .= $k.')';
                        $values .= '?)';
                        array_push($bindParam, $data[$k]);
                    }
                    $flag++;
                }
            }
            $sql .= ' '.$params.' VALUES '.$values;
        }else {//插入多行
            if($len == 1) {//(兼容一个长度的二维数组写法)
                foreach($data[0] as $k=>$v) {
                    if(count($data[0]) == 1) {//二维数组里放了一个数组且只有一个字段
                        $params .= '('.$k.')';
                        $values .= '(?)';
                        array_push($bindParam, $data[0][$k]);
                    }else {//二维数组里放了一个数组拥有多个字段
                        if($flag == 1) {
                            $params .= '('.$k.',';
                            $values .= '(?,';
                            array_push($bindParam, $data[0][$k]);
                        }elseif($flag == count($data[0])) {
                            $params .= $k.')';
                            $values .= '?)';
                            array_push($bindParam, $data[0][$k]);
                        }
                        $flag++;
                    }
                }
            }else {//标准二维数组多键值对
                if(count(array_keys($data[0])) == 1) {//仅有一个字段
                    $params .= '('.array_keys($data[0])[0].')';
                    if($len == 1) {//仅有一行插入的兼容
                        $values .= '(?)';
                        array_push($bindParam, $data[array_keys($data[0])[0]]);
                    }else {//多行单字段
                        for($i=0,$l=$len;$i<$len;$i++) {
                            if($i !== $l - 1) {
                                $values .= '(?),';
                            }else {
                                $values .= '(?)';
                            }
                            array_push($bindParam, $data[$i][array_keys($data[$i])[0]]);
                        }
                    }   
                }else {//多个字段
                    $params .= '('.implode(',',array_keys($data[0])).')';
                    for($i=0,$l=$len;$i<$l;$i++) {
                        $tmpArr = array_values($data[$i]);
                        array_walk($tmpArr, function(&$v, $k) use (&$bindParam){
                            array_push($bindParam, $v);
                            $v = '?';
                        });
                        if($i !== $l - 1) {
                            $values .= '('.implode(',',$tmpArr).'),';
                        }else {
                            $values .= '('.implode(',',$tmpArr).')';
                        }
                    }
                }   
            }
            $sql .= ' '.$params.' VALUES '.$values;
        }
        $sth = self::bindParam(self::$conn->prepare($sql),$bindParam);
        $sth->execute();
        return $sth->rowCount();
    }

    /**
     * 参数绑定
     * @param object $sth 预处理的语句返回的对象
     * @param array $param 待绑定的参数
     * @return object
     */
    private static function bindParam(object $sth, array $param)
    {
        if(!empty($param)) {
            for($i=1,$l=count($param);$i<=$l;$i++) {
                $sth->bindParam($i, $param[$i - 1]);
            }
        }
        return $sth;
    }

    private function __clone() {}//防止外部克隆
}

//如何使用?
// $db = Mysql::getInstance();如果觉得麻烦 可自行使用助手函数封装为 function db() {
//                                                                return Mysql::getInstance();
//                                                             }
// 则可以直接 db()->select()  db()->update() db()->insert
// 查询
//      $db->select("SELECT * FROM table_name WHERE xid = ? LIMIT ?", [3,5]);查询xid=3的5条数据
// 更新
//      $db->update("UPDATE table_name SET XXX = ? WHERE id = ?", ['test',3]);更新id=3的XXX为'test'
// 插入
//      $db->insert("table_name", [...]);[...]为待插入数据的数组