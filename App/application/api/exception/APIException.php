<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/23
 * Time: 12:30
 */

namespace app\api\exception;

use think\Exception;

class APIException extends Exception
{
    /**
     * @var int
     */
    private $httpcode;
    /**
     * @var int
     */
    private $status;
    /**
     * @var string
     */
    private $msg;
    /**
     * @var array
     */
    private $dataArray;

    /**
     * APIException constructor.
     * @param string $message   业务提示信息
     * @param int $httpcode     http状态码
     * @param int $status       业务状态码
     * @param array $dataArray       业务数据
     */
    public function __construct($message = "", $httpcode = 500, $status = 0 , $dataArray = [])
    {
        $this->httpcode = $httpcode;
        $this->status = $status;
        $this->msg = $message;
        $this->dataArray = $dataArray;
    }

    /**
     * @return int
     */
    public function getHttpcode()
    {
        return $this->httpcode;
    }

    /**
     * @param int $httpcode
     */
    public function setHttpcode($httpcode)
    {
        $this->httpcode = $httpcode;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        return $this->dataArray;
    }

    /**
     * @param array $dataArray
     */
    public function setDataArray($dataArray)
    {
        $this->dataArray = $dataArray;
    }

}