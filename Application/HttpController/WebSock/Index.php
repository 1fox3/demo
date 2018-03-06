<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/3/6
 * Time: 下午2:51
 */

namespace App\HttpController\WebSock;


use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Swoole\ServerManager;

class Index extends Controller
{

    function index()
    {
        // TODO: Implement index() method.
        $content = file_get_contents(__DIR__.'/client.html');
        $this->response()->write($content);
    }

    /*
     * 请调用who，获取fd
     * http://ip:9501/push/index.html?fd=xxxx
     */
    function push()
    {
        $fd = intval($this->request()->getRequestParam('fd'));
        $info = ServerManager::getInstance()->getServer()->connection_info($fd);
        if(is_array($info)){
            ServerManager::getInstance()->getServer()->push($fd,'push in http at '.time());
        }else{
            $this->response()->write("fd {$fd} not exist");
        }
    }
}