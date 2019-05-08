<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    /**
     * 错误码
     *
     * @var array
     */
    protected $errors = [

        "10000" => "参数错误!",
        "10001" => "数据不存在!",

        //资源相关错误
        "20001" => "资源不存在!",

        //接口错误
        "30000" => "接口请求状态码异常!",

    ];

    /**
     * 错误码
     *
     * @var int
     */
    protected $code = 0;

    /**
     * 错误消息
     *
     * @var string
     */
    protected $msg = "";

    /**
     * 错误附加数据
     *
     * @var array
     */
    protected $data = [];

    /**
     * AppException constructor.
     * @param $code
     * @param array $data
     */
    public function __construct($code, $data = [])
    {
        $this->code = $code;
        $this->data = $data;
        $this->msg = isset($this->errors[$code]) ? $this->errors[$code] : $this->msg;
    }

    /**
     * 格式化错误信息
     *
     * @return array|int
     * @author jiangxianli
     * @created_at 2019-05-07 17:30
     */
    public function formatError()
    {
        return [
            'code' => $this->code,
            'msg'  => $this->msg,
            'data' => $this->data,
        ];
    }
}
