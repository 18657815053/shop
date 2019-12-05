<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 20:32
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    protected function checkPrimaryScope()
    {
        TokenService::needPrimarySope();
    }

    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }

}