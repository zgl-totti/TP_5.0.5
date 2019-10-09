<?php

namespace app\api\controller\v1;

use app\common\service\Aes;

class User extends AuthBase
{
    //用户基本信息，隐私信息必须加密
    public function read()
    {
        $user = (new Aes)->encrypt($this->user);
        return api(1, 'ok', $user, 200);
    }

    public function update()
    {
        $post = input('post.');
        $data = [];

        if (!empty($post['image'])) {
            $data['image'] = $post['image'];
        }
        if (!empty($post['username'])) {
            $data['username'] = $post['username'];
        }
        if (!empty($post['sex'])) {
            $data['sex'] = $post['sex'];
        }
        if (!empty($post['signature'])) {
            $data['signature'] = $post['signature'];
        }

        if (empty($post)) {
            return api(0, '数据不合法', [], 404);
        }

        try {
            $user = new User();
            $row = $user->save($data);
            if ($row) {
                return api(1, '更新成功', [], 202);
            } else {
                return api(0, '更新失败', [], 401);
            }
        } catch (\Exception $e) {
            return api(0, $e->getMessage(), [], 500);
        }
    }
}