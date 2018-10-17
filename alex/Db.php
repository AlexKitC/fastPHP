<?php
/**
 * Db类，采用pdo实现，php请开启php_pdo_mysql的扩展
 * @author Alex-黑白
 * @QQ 392999164
 */
namespace Db;
class Db{

    private $conn;
    private $sql;

    public function __construct(){
        if(!class_exists('pdo')){
            die('错误！当前环境未开启php_pdo_mysql扩展');
        }else{
            try{
                $conn = new \PDO("mysql:host=".SQLHOST.";dbname=".DATABASE,SQLUSERNAME,SQLPASSWORD,array(\PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
                if($conn){
                    $this -> conn = $conn;
                }
            }catch(\PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    /**
     * 查询多个符合条件的条目 返回二维数组
     * @param $table  表名字
     * @param $fields 查询的字段(仅支持数组)
     * @param $where  查询条件(条件)
     * @param $limit  查询的条数
     * @param $orderBy 排序
     */
    public function query($table,$fields="*",$where='',$limit='',$orderBy=""){
        $table = SQLTABLEPREFIX == ''?$table:SQLTABLEPREFIX.$table;
        $where = $where == ''?"":" WHERE ".$where;
        $limit = $limit == ''?"":" LIMIT ".$limit;
        $orderBy = $orderBy == ""?"":" ORDER BY ".$orderBy;
        $sql = "";
        if(is_array($fields)){
            $filedsStr = implode(",",$fields);
            $sql = "SELECT ".$filedsStr." FROM ".$table.$where.$limit.$orderBy;
            $this -> sql = $sql;
            $tmp_cost = microtime(true);
            $res = $this -> conn -> prepare($sql);
            $res -> execute();
            $resultArr = $res -> fetchAll(\PDO::FETCH_ASSOC);
            $this -> dbLog($sql,round((microtime(true)-$tmp_cost),5));
            return $resultArr;
        }else{
            die('Class Db() function query params($fields) must be array!');
        }   
    }

    /**
     * 查询单个条目 返回一维数组
     * @param $table  表名
     * @param $fields 查询的字段(仅支持数组)
     * * @param $where  查询条件(条件)
     */
    public function find($table,$fields,$where=''){
        $table = SQLTABLEPREFIX == ''?$table:SQLTABLEPREFIX.$table;
        $where = $where == ''?"":" WHERE ".$where;
        if(is_array($fields)){
            $filedsStr = implode(",",$fields);
            $sql = "SELECT ".$filedsStr." FROM ".$table.$where." LIMIT 1";
            $this -> sql = $sql;
            $tmp_cost = microtime(true);
            $res = $this -> conn -> prepare($sql);
            $res -> execute();
            $resultArr = $res -> fetch(\PDO::FETCH_ASSOC);
            $this -> dbLog($sql,round((microtime(true)-$tmp_cost),5));
            return $resultArr;
        }else{
            die('Class Db() function query params($fields) must be array!');
        }
    }
    

    /**
     * 获取条目
     * @param $table 表名
     */
    public function getCount($table){
        $table = SQLTABLEPREFIX == ''?$table:SQLTABLEPREFIX.$table;
        $sql = "SELECT count('*') FROM ".$table;
        $this -> sql = $sql;
        $tmp_cost = microtime(true);
        $result = $this -> conn -> query($sql);
        $this -> dbLog($sql,round((microtime(true)-$tmp_cost),5));
        return $result->fetchColumn();
    }

    /**
     * 插入单个条目 返回受影响的行
     * @param $table  表名
     * @param $fields 插入的字段(仅支持数组)
     */
    public function insert($table,$fields){
        $table = SQLTABLEPREFIX == ''?$table:SQLTABLEPREFIX.$table;
        $fields_keys = array_keys($fields);
        $fields_vals = array_values($fields);
        $pre = "";
        $aft = "";
        foreach($fields_keys as $k => $v){
            if($k == 0){
                $pre = " (".$fields_keys[$k];
                $aft = " VALUES (?";
            }elseif($k < count($fields_keys)-1){
                $pre .= ",".$fields_keys[$k];
                $aft .= ",?";
            }elseif($k == count($fields_keys)-1){
                $pre .= ",".$fields_keys[$k].")";
                $aft .= ",?)";
            }
        }
        $sql = "INSERT INTO ".$table.$pre.$aft;
        $stmt = $this -> conn -> prepare($sql);
        foreach($fields_vals as $k => $v){
            $stmt -> bindParam($k+1,$fields_vals[$k]);
        }
        $res = $stmt -> execute();
        return $res;
    }

    /**
     * 数据库行为日志记录
     * @param $sql  执行的sql语句
     * @param $cost 执行耗时
     */
    public function dbLog($sql,$cost){
        if(DB_LOG_TURN == 'TRUE'){
            $date = date("Y-m-d H:i:s",time());
            $info = $date." ".$sql." cost ".$cost."ms "."\r\n";
            $dateDir = date("Ymd",time());
            $file = APP_PATH."/logs/db/".date("Ymd").".log";
            file_put_contents($file,$info,FILE_APPEND);
        }   
    }

}