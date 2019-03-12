<?php
/**
 * Created by PhpStorm.
 * User: CCM
 * Date: 2018/8/3
 * Time: 14:57
 * 帮助函数
 */

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
if (!function_exists('list_to_tree')) {
    function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}
/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree 原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array $list 过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
if (!function_exists('tree_to_list')) {
    function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array())
    {
        if (is_array($tree)) {
            $refer = array();
            foreach ($tree as $key => $value) {
                $reffer = $value;
                if (isset($reffer[$child])) {
                    unset($reffer[$child]);
                    tree_to_list($value[$child], $child, $order, $list);
                }
                $list[] = $reffer;
            }
            $list = list_sort_by($list, $order, $sortby = 'asc');
        }
        return $list;
    }
}


/*
 * 获取随机验证码字符串
 */
if (!function_exists('get_rand_str')) {
    function get_rand_str($length)
    {
        $str = '0123456789';
        $len = strlen($str) - 1;
        $randstr = '';
        for ($i = 0; $i < $length; $i++) {
            $num = mt_rand(0, $len);
            $randstr .= $str[$num];
        }
        return $randstr;
    }
}

/*
 *权限select框
 * */
if (!function_exists('permission_select')) {
    function permission_select($id = 0,$selected = 0, $type = 0)
    {
        $list = Spatie\Permission\Models\Permission::getSpaceTreeData();
        if ($type == 1) {
            $str = '<option value="">请选择权限</option>';
        } else {
            $str = '<option value="0">顶级权限</option>';
        }

        if ($list) {
            foreach ($list as $key => $val) {
                $str .= '<option value="' . $val['id'] . '" '
                    . ($id == $val['id'] ? 'disabled' : '')
                    . ($selected == $val['id'] ? 'selected="selected"' : '') . '>'
                    . $val['space'] . $val['display_name'] .'('. $val['name'] .')'. '</option>';
            }
        }
        return $str;
    }
}


if (!function_exists('formatTreeData')) {
    function formatTreeData($data, $id = "id", $parent_id = "parent_id", $root = 0, $space = '&nbsp;&nbsp;|--&nbsp;', $level = 0)
    {
        $arr = array();
        if ($data) {
            foreach ($data as $v) {
                if ($v[$parent_id] == $root) {
                    $v['level'] = $level + 1;
                    $v['space'] = $root != 0 ? str_repeat($space, $level) : '' . str_repeat($space, $level);
                    $arr[] = $v;
                    $arr = array_merge($arr, formatTreeData($data, $id, $parent_id, $v[$id], $space, $level + 1));
                }
            }
        }
        return $arr;
    }
}

/*
 * */
if(!function_exists("role_select")){
    function role_select($selected = '', $type = 1)
    {
        $list = Spatie\Permission\Models\Role::where(['status'=>1])->get();

        if ($type == 1) {
            $str = '<option value="">请选择角色</option>';
        } else {
            $str = '';
        }
        if ($list) {
            foreach ($list as $key => $val) {

                if ($type) {
                    $str .= '<option value="' . $val['id'] . '" '
                        . ($selected == $val['id'] ? 'selected="selected"' : '') . '>'
                        . $val['display_name'] .'('. $val['name'] .')'. '</option>';
                } else {
                    $str .= '<option value="' . $val['id'] . '" '
                        . (in_array($val['id'], (array)$selected) ? 'selected="selected"' : '') . '>'
                        . $val['display_name'] .'('. $val['name'] .')'. '</option>';
                }
            }
        }
        return $str;
    }
}

/*
 * 二维数组合并转成一维数组 然后去重
 * */
if(!function_exists("get_user_permission")){
    function get_user_permission() {

        //当前用户的permission
        $user = \App\User::where("id",auth()->id())->with("roles.permission")->first();
        $arr = [];
        foreach ($user->roles as $k=>$v){
            $arr[] = $v->permission->pluck("name")->all();
        }

        $result = array_reduce($arr, function ($result, $value) {
            return array_merge($result, array_values($value));
        }, array());
        return array_unique($result);
    }
}

/*
 * 没有权限
 * */

if(!function_exists("no_permission")){
    function no_permission($permission)
    {
        if(!\Illuminate\Support\Facades\Auth::user()->can(config('permissions.'.$permission))){
            return true;
        }
    }
}
