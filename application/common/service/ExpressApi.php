<?php

namespace app\common\service;


class ExpressApi
{
    /**
     * 来源：快递网（http://www.kuaidi.com)
     */

    /**
     * 快递网接口查询KEY
     */
    private $key='c684ab43a28bc3caea53570666ce9762';
    private $url='http://highapi.kuaidi.com/openapi-querycountordernumber.html?';
    private $show = 0;
    private $num = 0;
    private $order = 'desc';

    private static $_instance = null;

    private function __construct(){}

    //静态方法，单例模式统一入口
    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance= new self();
        }

        return self::$_instance;
    }

    /**
     * 设置数据返回类型。0: 返回 json 字符串; 1:返回 xml 对象
     * @param number $show
     */
    public function setShow($show = 0)
    {
        $this->show = $show;
    }


    /**
     * 设置返回物流信息条目数, 0:返回多行完整的信息; 1:只返回一行信息
     * @param number $muti
     */
    public function setNum($num = 0)
    {
        $this->num = $num;
    }

    /**
     * 设置返回物流信息排序。desc:按时间由新到旧排列; asc:按时间由旧到新排列
     * @param string $order
     */
    public function setOrder($order = 'desc')
    {
        $this->order = $order;
    }

    /**
     * 查询物流信息，传入单号，
     * @param 物流单号 $express_sn
     * @param 公司简码 $com 要查询的快递公司代码,不支持中文,具体请参考快递公司代码文档。 不填默认根据单号自动匹配公司。注:单号匹配成功率高于 95%。
     * @throws Exception
     * @return array
     */
    public function query($express_sn, $com = '')
    {
        if (function_exists('curl_init') == 1) {
            $url = $this->url;
            $dataArr = array(
                'id' => $this->key,
                'com' => $com,
                'nu' => $express_sn,
                'show' => $this->show,
                'muti' => $this->num,
                'order' => $this->order
            );

            foreach ($dataArr as $key => $value) {
                $url .= $key . '=' . $value . "&";
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);

            $res = curl_exec($curl);
            curl_close($curl);

            if ($this->_show == 0) {

                $result = json_decode($res, true);
            } else {

                $result = $res;
            }

            return $result;

        } else {

            throw new \Exception("Please install curl plugin", 1);
        }
    }
}