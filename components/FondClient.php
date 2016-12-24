<?php
/**
 * Created by PhpStorm.
 * User: qsq
 * Date: 24/12/2016
 * Time: 2:16 PM
 */

namespace summic\fond\components;

use yii;

class FondClient
{
    public function __construct()
    {
        $collection = Yii::$app->get('authClientCollection');
        $this->client = $collection->getClient('fond');
    }

    /**
     * 发送企业微信通知
     * @param $to
     * @param $text
     * @param string $priority
     * @return mixed
     */
    public function Notification($to,$text,$priority='low'){
        $params = [
            'to' => $to,
            'text' => $text,
            'priority' => $priority
        ];
        return $this->client->api('notification/send', 'post', $params);
    }

    /**
     * 获取组织架构
     * @param $department_id
     * @return mixed
     */
    public function DepartmentList($department_id){
        return $this->client->api('department/list', 'get', ['id'=>$department_id]);
    }

    /**
     * 获取组织架构下的用户信息
     * @param $department_id
     * @return mixed
     */
    public function DepartmentUser($department_id){
        return $this->client->api('department/user', 'get', ['id'=>$department_id]);
    }

}