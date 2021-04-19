<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 蜘蛛访问统计管理
// +----------------------------------------------------------------------
namespace addons\spider\Controller;

use addons\spider\model\Spider as SpiderModel;
use app\addons\util\Adminaddon;
use think\Db;

class Admin extends Adminaddon
{
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new SpiderModel;
    }

    public function delall()
    {

    }

    public function statistics()
    {
        if ($this->request->isPost()) {
            $date = $this->request->post('date', '');
            $type = $this->request->post('type', '');
            if ($type == 'spider') {
                list($xAxisData, $seriesData) = $this->getSpiderData($date);
                $statistics                   = ['xAxisData' => $xAxisData, 'seriesData' => $seriesData];
            } elseif ($type == 'source') {
                $SourceData = $this->getSourceData($date);
                $statistics = ['SourceData' => $SourceData];
            }
            $this->success('', '', $statistics);
        } else {
            list($xAxisData, $seriesData) = $this->getSpiderData();
            $this->assign('xAxisData', $xAxisData);
            $this->assign('seriesData', $seriesData);

            $SourceData = $this->getSourceData();
            $this->assign('SourceData', $SourceData);
            return $this->fetch();
        }
    }

    protected function getSpiderData($date = '')
    {
        if ($date) {
            list($start, $end) = explode(' - ', $date);
            $start_time        = strtotime($start);
            $end_time          = strtotime($end);
        } else {
            $start_time = \util\Date::unixtime('day', 0, 'begin');
            $end_time   = \util\Date::unixtime('day', 0, 'end');
        }
        $diff_time = $end_time - $start_time;
        $format    = '%Y-%m-%d';
        if ($diff_time > 86400 * 30 * 2) {
            $format = '%Y-%m';
        } else {
            if ($diff_time > 86400) {
                $format = '%Y-%m-%d';
            } else {
                $format = '%H:00';
            }
        }
        $list  = $xAxisData  = $seriesData  = [];
        $field = 'FROM_UNIXTIME(create_time, "' . $format . '") as create_times,COUNT(*) AS num';
        $res   = Db::name('spider')->field($field)->where('create_time', 'between time', [$start_time, $end_time])->group('create_times')->select();
        if ($diff_time > 84600 * 30 * 2) {
            $start_time = strtotime('last month', $start_time);
            while (($start_time = strtotime('next month', $start_time)) <= $end_time) {
                $column[] = date('Y-m', $start_time);
            }
        } else {
            if ($diff_time > 86400) {
                for ($time = $start_time; $time <= $end_time;) {
                    $column[] = date("Y-m-d", $time);
                    $time += 86400;
                }
            } else {
                for ($time = $start_time; $time <= $end_time;) {
                    $column[] = date("H:00", $time);
                    $time += 3600;
                }
            }
        }
        $list = array_fill_keys($column, 0);
        foreach ($res as $k => $v) {
            $list[$v['create_times']] = $v['num'];
        }
        $category = array_keys($list);
        $data     = array_values($list);
        return [$category, $data];
    }

    public function getSourceData($date = '')
    {
        if ($date) {
            list($start, $end) = explode(' - ', $date);
            $start_time        = strtotime($start);
            $end_time          = strtotime($end);
        } else {
            $start_time = \util\Date::unixtime('day', 0, 'begin');
            $end_time   = \util\Date::unixtime('day', 0, 'end');
        }
        $diff_time = $end_time - $start_time;
        $format    = '%Y-%m-%d';
        if ($diff_time > 86400 * 30 * 2) {
            $format = '%Y-%m';
        } else {
            if ($diff_time > 86400) {
                $format = '%Y-%m-%d';
            } else {
                $format = '%H:00';
            }
        }
        $dataList       = [];
        $SourceCategory = $SourceAmount = $SourceNums = [];

        $list = Db::name('spider')
            ->where('create_time', 'between time', [$start_time, $end_time])
            ->field('spider,COUNT(*) as nums')
            ->group('spider')
            ->select();

        foreach ($list as $k => $v) {
            $dataList[] = [
                'name'  => $v['spider'],
                'value' => $v['nums'],
            ];
        }
        return $dataList;
    }

}
