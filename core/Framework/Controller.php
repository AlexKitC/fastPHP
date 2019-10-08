<?php
namespace Core\Framework;
class Controller
{

    /**
     * 成功的跳转
     * @param string $msg
     * @param array $interval
     * @param string $pathinfo
     */
    public function success(string $msg = '操作成功', int $interval = 3, string $pathinfo)
    {
        show('success', ['title'=>'成功提示', 'msg'=>$msg, 'interval'=>$interval], false);
    }

    /**
     * 简易分页
     * @param int $num 每页显示的条目
     */
    public function simplePaginate(int $num)
    {
        
    }
}