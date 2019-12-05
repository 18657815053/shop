<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 21:18
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\valiDate\TokenGet;

class Token
{
    /*
     * 获取token
     * @url /api/v1/token
     * @http POST
     * @param string $code 通过调用wx.login接口返回的code
     * @return json
     */
    public function getToken($code = '')
    {
        (new TokenGet())->gocheck();

        $obj = new UserToken($code);
        $token = $obj->get();
        return ['token' => $token];
    }
}