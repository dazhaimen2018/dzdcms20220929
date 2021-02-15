<?php
namespace addons\dataoutput\library;

use Exception;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use think\Db;

/**
 * 导出导入Excel
 *
 * Class Excel
 * @package jianyan\excel
 * @author jianyan74 <751393839@qq.com>
 */
class Excel
{
    public $fields = [];
    public $config = [];

    public function __construct($config)
    {
        $this->config = $config;
        if ($this->config['config'] && isset($this->config['config'])) {
            foreach ($this->config['config']['comment'] as $key => $vo) {
                $title                           = $this->config['table'] . '.' . $key;
                $this->fields[$title]['field']   = $key;
                $this->fields[$title]['comment'] = $vo;
                $this->fields[$title]['format']  = $this->config['config']['format'][$key];
                $this->fields[$title]['parm']    = $this->config['config']['parm'][$key];
                $this->fields[$title]['table']   = $this->config['table'];
            }
        }
        if (isset($this->config['join_table']) && !empty($this->config['join_table']) && is_array($this->config['join_table'])) {
            foreach ($this->config['join_table'] as $key => $vo) {
                $join_table_name = $vo['table'];
                if (isset($this->config['join_table'][$key]['fields']) && isset($this->config['join_table'][$key]['fields']['comment'])) {
                    foreach ($this->config['join_table'][$key]['fields']['comment'] as $k => $v) {
                        $title                           = $join_table_name . '.' . $k;
                        $this->fields[$title]['field']   = $k;
                        $this->fields[$title]['comment'] = $v;
                        $this->fields[$title]['format']  = $this->config['join_table'][$key]['fields']['format'][$k];
                        $this->fields[$title]['parm']    = $this->config['join_table'][$key]['fields']['parm'][$k];
                        $this->fields[$title]['table']   = $join_table_name;
                    }
                }
            }
        }
    }

    /**
     * 导出Excel
     *
     * @param string $filename  导出的文件名
     * @param string $path      导出的存放地址 无则不在服务器存放
     * @param string $image    导出的格式 可以用 大写字母 或者 数字 标识 哪一列
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportData($filename = '', $path = '', $image = [])
    {
        $header = $this->getHeader();
        $list   = Db::query($this->buildSql());
        $suffix = $this->config['type'];
        if (!is_array($list) || !is_array($header)) {
            return false;
        }

        // 清除之前的错误输出
        ob_end_clean();
        ob_start();

        !$filename && $filename = time();

        // 初始化
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        // 写入头部
        $hk = 1;
        foreach ($header as $k => $v) {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($hk) . '1', $v[0]);
            $hk += 1;
        }

        // 开始写入内容
        $column = 2;
        $size   = ceil(count($list) / 500);
        for ($i = 0; $i < $size; $i++) {
            $buffer = array_slice($list, $i * 500, 500);

            foreach ($buffer as $k => $row) {
                $span = 1;

                foreach ($header as $key => $value) {
                    // 解析字段
                    $realData = $this->formatting($header[$key], trim($this->formattingField($row, $value[1])), $row);
                    // 写入excel
                    $rowR = Coordinate::stringFromColumnIndex($span);
                    $sheet->getColumnDimension($rowR)->setWidth(20);

                    $sheet->setCellValue($rowR . $column, $realData);
                    $span++;
                }

                $column++;
                unset($buffer[$k]);
            }
        }
        unset($list);

        // 直接输出下载
        switch ($suffix) {
            case 'xlsx':
                $writer = new Xlsx($spreadsheet);
                if (!empty($path)) {
                    $writer->save($path);
                } else {
                    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8;");
                    header("Content-Disposition: inline;filename=\"{$filename}.xlsx\"");
                    header('Cache-Control: max-age=0');
                    $writer->save('php://output');
                }
                exit();

                break;
            case 'xls':
                $writer = new Xls($spreadsheet);
                if (!empty($path)) {
                    $writer->save($path);
                } else {
                    header("Content-Type:application/vnd.ms-excel;charset=utf-8;");
                    header("Content-Disposition:inline;filename=\"{$filename}.xls\"");
                    header('Cache-Control: max-age=0');
                    $writer->save('php://output');
                }
                exit();

                break;
            case 'csv':
                $writer = new Csv($spreadsheet);
                if (!empty($path)) {
                    $writer->save($path);
                } else {
                    header("Content-type:text/csv;charset=utf-8;");
                    header("Content-Disposition:attachment; filename={$filename}.csv");
                    header('Cache-Control: max-age=0');
                    $writer->save('php://output');
                }
                exit();

                break;
            case 'html':
                $writer = new Html($spreadsheet);
                if (!empty($path)) {
                    $writer->save($path);
                } else {
                    header("Content-Type:text/html;charset=utf-8;");
                    header("Content-Disposition:attachment;filename=\"{$filename}.{$suffix}\"");
                    header('Cache-Control: max-age=0');
                    $writer->save('php://output');
                }
                exit();

                break;
        }
        return true;
    }

    //获取表头
    public function getHeader()
    {
        foreach ($this->fields as $key => $vo) {
            $comment  = !empty($vo['comment']) ? $vo['comment'] : $key;
            $header[] = [$comment, $vo['field'], $vo['format'], $vo['parm']];
        }
        return $header;
    }

    //解析sql语句
    public function buildSql()
    {
        foreach ($this->fields as $key => $value) {
            $field .= $key . ',';
        }
        $field = trim($field, ',');

        $sql = Db::table($this->config['table']);
        if (isset($this->config['join_table']) && !empty($this->config['join_table']) && is_array($this->config['join_table'])) {
            foreach ($this->config['join_table'] as $key => $value) {
                if ($value['table'] && $value['primary_key'] && $value['foreign_key']) {
                    $join_table_name = $value['table'];
                    $condition       = vsprintf('%s.%s = %s.%s', [
                        $this->config['table'],
                        $value['foreign_key'],
                        $join_table_name,
                        $value['primary_key'],
                    ]);
                    $join_table[] = [$join_table_name, $condition];
                }
            }
            $sql = $sql->join($join_table);
        }
        $sql = $sql->field($field)->fetchSql(true)->select();
        return $sql;
    }

    /**
     * 格式化内容
     *
     * @param array $array 头部规则
     * @return false|mixed|null|string 内容值
     */
    protected function formatting(array $array, $value, $row)
    {
        (!isset($array[2]) || empty($array[2])) && $array[2] = 'text';

        switch ($array[2]) {
            // 文本
            case 'text':
                return $value;
                break;
            // 日期
            case 'date':
                return !empty($value) ? date(empty($array[3]) ? "Y-m-d H:i:s" : $array[3], $value) : null;
                break;
            // 选择框
            case 'selectd':
                return $this->strToArr($array[3], $value);
                break;
            // 匿名函数
            case 'function':
                return isset($array[3]) ? call_user_func($array[3], $row) : null;
                break;
            // 默认
            default:
                break;
        }

        return null;
    }

    protected function strToArr($str, $val)
    {
        $arr1 = array_filter(array_map('trim', explode(',', $str)));
        $arr2 = [];
        foreach ($arr1 as $key => $v) {
            list($key, $v) = explode('=', $v);
            $arr2[$key]    = $v;
        }
        return isset($arr2[$val]) ? $arr2[$val] : null;
    }

    /**
     * 解析字段
     *
     * @param $row
     * @param $field
     * @return mixed
     */
    protected function formattingField($row, $field)
    {
        $newField = explode('.', $field);
        if (count($newField) == 1) {
            if (isset($row[$field])) {
                return $row[$field];
            } else {
                return false;
            }
        }

        foreach ($newField as $item) {
            if (isset($row[$item])) {
                $row = $row[$item];
            } else {
                break;
            }
        }

        return is_array($row) ? false : $row;
    }
}
