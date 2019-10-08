<?php
namespace Core\Framework;
class View {

    private $suffix;
    public  $value;
    private static $instance;

    private function clone() {}

    /**
     * 初始化模板后缀
     */
    private function __construct() {
        $this -> suffix = strtolower(config('suffix'));
    }

    /**
     * 获取视图实例
     */
    public static function getInstance() {
        if(!self::$instance) {
            return new self();
        }
        return self::$instance;
    }

    /**
     * 渲染html模板
     */
    public function show(string $path, array $params = [], bool $isViews = true) {
        $html_path_arr = (explode('/',$path));
        $html_path_str = '';
        $base_path = $isViews ? APP_ROOT.'/app/Views/' : APP_ROOT.'/core/Tpl/';
        for($i=0,$l=count($html_path_arr);$i<$l;$i++) {
            if($i < $l - 1) {
                $html_path_str .= ucfirst($html_path_arr[$i]).'/';
            }elseif($i == $l - 1) {
                $base_path .= $html_path_str;
                $base_path .= $html_path_arr[$i].config('suffix');
            }
        }
        if($this->htmlExist($base_path)) {
            if(!empty($params)) {
                foreach($params as $k => $v) {
                    $this->assign($k,$v);
                }
                extract($this->value);
            }
            include $base_path;
        }else {
            throw new \Exception('html file: '.$base_path.'不存在 :(');
        }
    }

    /**
     * 模板变量赋值
     */
    public function assign($key,$val)
    {
        if(array($val)) {
            $this->value[$key] = $val;
        }else {
            $this->value[$key] = compact($val);
        }
    }

    /**
     * 检查模板文件是否存在
     * @param string $html_path
     */
    private function htmlExist(string $html_path)
    {
        if(file_exists($html_path)) {
            return $html_path;
        }else {
            return false;
        }
    }
}