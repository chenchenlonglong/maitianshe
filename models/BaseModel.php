<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/16
 * Time: 17:53
 */

namespace app\models;


use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    const SUCC=200;
    const  FAIL=300;

    /**
     * 获取列表（分页）
     * @param unknown $query
     * @param number $curPage
     * @param number $pageSize
     * @param string $search
     * @return multitype:number multitype: |unknown
     */
    public function getPages($query,$curPage = 1,$pageSize = 10 ,$search = null)
    {
        if($search)
            $query = $query->andFilterWhere($search);

        $data['count'] = $query->count();
        if(!$data['count'])
            return ['count'=>0,'curPage'=>$curPage,'pageSize'=>$pageSize,'start'=>0,'end'=>0,'data'=>[]];

        $curPage = (ceil($data['count']/$pageSize)<$curPage)?ceil($data['count']/$pageSize):$curPage;

        $data['curPage'] = $curPage;
        //每页显示条数
        $data['pageSize'] = $pageSize;
        //起始页
        $data['start'] = ($curPage-1)*$pageSize+1;
        //末页
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage)?$data['count']:($curPage-1)*$pageSize+$pageSize;
        //数据
        $data['data'] = $query->offset(($curPage-1)*$pageSize)->limit($pageSize)->orderby('created_at')->asArray()->all();

        return $data;

    }

    /**
     * @desc 分页查询
     * @param $query 执行的sql
     * @param int $Page 当前也是
     * @param int $page_num 每一页显示的条数
     * @param string $orderby 排序方式
     * @param null $search 查询条件
     * @param null $time_first 时间
     * @param null $time_sec  时间
     * @return array
     */
    public function getPage($query,$Page = 1,$page_num= 10 ,$orderby="",$search = null,$time_first=null,$time_sec=null)
    {
        if($search){
            $query = $query->andFilterWhere($search);
        }
        if($time_first){
            $query =$query->andWhere($time_first);
        }
        if($time_sec){
            $query =$query->andWhere($time_sec);
        }
        $data['total'] = $query->count();
        if(!$data['total']){
            return ['count'=>0,'curPage'=>$Page,'pageSize'=>$page_num,'start'=>0,'end'=>0,'data'=>[]];
        }
        $Page = (ceil($data['total']/$page_num)<$Page)?ceil($data['total']/$page_num):$Page;
        $data['page'] = $Page;
        //每页显示条数
        $data['page_num'] = $page_num;
        //起始页
        $data['start'] = ($Page-1)*$page_num+1;
        //末页
        $data['end'] = (ceil($data['total']/$page_num) == $Page)?$data['total']:($Page-1)*$page_num+$page_num;
        //数据
        $data['data'] = $query->offset(($Page-1)*$page_num)->limit($page_num)->orderby($orderby)->asArray()->all();
        return $data;
    }



    /**
     * @desc 通过sql语句使用的分页工具
     * @param $query 查询模型
     * @param int $Page 当前页码
     * @param int $page_num 每页大小
     * @param null $search 查询条件
     * @return array
     */

    public function getPage_by_sql($query,$Page = 1,$page_num= 10)
    {
        $data['total'] =count($query);
        if(!$data['total']){
            return ['count'=>0,'curPage'=>$Page,'pageSize'=>$page_num,'start'=>0,'end'  =>0,'data'=>[]];
        }
        $Page = (ceil($data['total']/$page_num)<$Page)?ceil($data['total']/$page_num):$Page;
        $data['page'] = $Page;
        //每页显示条数
        $data['page_num'] = $page_num;
        //起始页
        $data['start'] = ($Page-1)*$page_num+1;
        //末页
        $data['end'] = (ceil($data['total']/$page_num) == $Page)?$data['total']:($Page-1)*$page_num+$page_num;
        return $data;
    }


}