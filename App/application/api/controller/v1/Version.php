<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/26
 * Time: 12:37
 */

namespace app\api\controller\v1;

use app\api\controller\Common;

class Version extends Common
{
    protected $myModel;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->myModel = model("common/Version");
    }

    public function read()
    {
        return $this->init();
    }
}