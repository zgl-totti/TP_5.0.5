<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7
 * Time: 14:54
 */
namespace app\common\model;

use think\Model;

class Sector extends Model{
    public function index(){
        $data=['ds','ws1','ws2','bm','bm2','bm3','tf','fengshi','fengshi2','gb','g1','g2','g3','g4','g5','g7','g8','g9','g10','fk','hx5','xc6','hngb','hnhx'];
        return $data;
    }
}