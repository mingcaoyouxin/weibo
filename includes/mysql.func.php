<?php
//防止恶意调用
if (!defined('IN_TG')) {
    exit('Access Defined!');
}


/**
 * _connect() 连接MYSQL数据库
 * @access public
 * @return void
 */

function _connect() {
    //global 表示全局变量的意思，意图是将此变量在函数外部也能访问
    global $_conn;
    if (!$_conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD)) {
        exit('数据库连接失败');
    }
}

/**
 * _select_db选择一款数据库
 * @return void
 */

function _select_db() {
    if (!mysql_select_db(DB_NAME)) {
        exit('找不到指定的数据库');
    }
}

/**
 *
 */

function _set_names() {
    if (!mysql_query('SET NAMES gbk')) {
        exit('字符集错误');
    }
}
/**
 *
 * @param $_sql
 */

function _query($_sql) {

    if (!$_result = mysql_query($_sql)) {
        exit('SQL执行失败');
    }
    return $_result;
}

/**
 *
 * @param $_sql
 * 函数返回值如下。
        成功：一个数组，该数组包含了查询结果集中当前行数据信息，数组下标范围0～记录属性数−1，数组中的第i个元素值为该记录第i个属性上的值。
        同时可以使用属性名来得到该属性上的值。
 */

function _fetch_array($_sql) {
    return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

/**
 * _fetch_array_list可以返回指定数据集的所有数据
 * @param $_result
 */

function _fetch_array_list($_result) {
    return mysql_fetch_array($_result,MYSQL_ASSOC);
}
/**
 * _affected_rows表示影响到的记录数
 * 关联型数组[Associative array]
 */

function _affected_rows() {
    return mysql_affected_rows();
}

/**
 *
 * @param $_sql
 * @param $_info
 */

function _is_repeat($_sql,$_info) {
    if (_fetch_array($_sql)) {
        _alert_back($_info);
    }
}


function _close() {
    if (!mysql_close()) {
        exit('关闭异常');
    }
}

?>