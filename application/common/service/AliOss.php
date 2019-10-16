<?php

namespace app\common\service;

use OSS\Core\OssException;
use OSS\OssClient;

class AliOss
{
    private static $_instance = null;

    private function __construct()
    {
    }

    /*
     * 静态方法，单例模式统一入口
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /*
     * oss上传
     */
    public function uploadFile($file)
    {
        if (empty($file)) {
            $res = [
                'code' => 0,
                'msg' => '上传文件不能为空！'
            ];

            return $res;
        }

        $extension = pathinfo($file->getInfo()['name'])['extension'];
        if (!in_array($extension, ['jpg', 'gif', 'png', 'jpeg'])) {
            $res = [
                'code' => 0,
                'msg' => '上传文件格式不符合规则！'
            ];

            return $res;
        }

        if ($file->getInfo()['size'] > 3145728) {
            $res = [
                'code' => 0,
                'msg' => '上传文件太大！'
            ];

            return $res;
        }

        $config = config('oss');
        $dir = 'college';

        try {
            //实例化
            $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['EndPoint']);
            //sha1加密 生成文件名 连接后缀
            $fileName = $dir . '/' . sha1(date('YmdHis', time()) . uniqid()) . '.' . $extension;
            //执行阿里云上传
            $result = $ossClient->uploadFile($config['Bucket'], $fileName, $file->getInfo()['tmp_name']);
            if ($result) {
                $res = [
                    'code' => 1,
                    'url' => $result['info']['url']
                ];
            } else {
                $res = [
                    'code' => 0,
                    'msg' => '上传失败！'
                ];
            }
        } catch (OssException $e) {
            $res = [
                'code' => 0,
                'msg' => $e->getMessage()
            ];
        }

        return $res;
    }

    /*
     * oss文件是否存在
     */
    public function fileExist($url)
    {
        if (empty($url)) {
            $res = [
                'code' => 0,
                'msg' => '文件路径不能为空！'
            ];

            return $res;
        }

        $config = config('oss');
        $file = str_replace($config['oss_url'], '', $url);

        try {
            $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['EndPoint']);
            $result = $ossClient->doesObjectExist($config['Bucket'], $file);
            if ($result) {
                $res = [
                    'code' => 1
                ];
            } else {
                $res = [
                    'code' => 0
                ];
            }
        } catch (OssException $e) {
            $res = [
                'code' => 0,
                'msg' => $e->getMessage()
            ];
        }

        return $res;
    }

    /*
     * 删除oss文件
     */
    public function delFile($url)
    {
        if (empty($url)) {
            $res = [
                'code' => 0,
                'msg' => '文件路径不能为空！'
            ];

            return $res;
        }

        $config = config('oss');
        $file = str_replace($config['oss_url'], '', $url);

        try {
            $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['EndPoint']);
            $result = $ossClient->deleteObject($config['Bucket'], $file);
            if ($result) {
                $res = [
                    'code' => 1
                ];
            } else {
                $res = [
                    'code' => 0
                ];
            }
        } catch (OssException $e) {
            $res = [
                'code' => 0,
                'msg' => $e->getMessage()
            ];
        }

        return $res;
    }
}