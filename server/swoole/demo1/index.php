<?php
namespace app\index\controller;

use app\common\Client;
use app\common\Predis;
use app\common\Sql;
use app\index\model\User;

class Index
{
    //创建房间(添加拍卖倒计时)
    public function chuangjian()
    {
        $data['time']=input("time");
        $data['id']=input("id");
        $cli = new Client();
        $cli->data = [
            'data' => 'chuangjian',
            'arr' => $data
        ];
        return $cli->lianjie();
    }
    //点击添加哈希(进入房间)
    public function jingru()
    {
        $data['name']=input("name");
        $data['uid']=input("uid");
        $cli = new Client();
        $cli->data = [
            'data' => 'jingru',
            'arr' => $data
        ];
        return $cli->lianjie();
    }
    //本房间推送(出价格成功并推送)
    public function pushfan()
    {
        $data['fan']=input("fan");
        $cli = new Client();
        $cli->data = [
            'data' => $data['fan'],
            'msg' => "恭喜用户111,喜当爹!!!!"
        ];
        return $cli->lianjie();
    }
    //时间结束并指定推送
    public function zhiding()
    {
        $data['fan']=input("fan");
        $cli = new Client();
        $cli->data = [
            'data' => $data['fan'],
            'msg' => "恭喜用户111,喜当爹!!!!"
        ];
        return $cli->lianjie();
    }

}