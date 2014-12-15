<?php
//��ֹ�������
if (!defined('IN_TG')) {
    exit('Access Defined!');
}

if (!function_exists('_alert_back')) {
    exit('_alert_back()���������ڣ�����!');
}

if (!function_exists('_mysql_string')) {
    exit('_mysql_string()���������ڣ�����!');
}

/**
 * _setcookies���ɵ�¼cookies
 * @param unknown_type $_username
 * @param unknown_type $_uniqid
 */


function _setcookies($_username,$_uniqid,$_time) {
    switch ($_time) {
        case '0':  //���������
            setcookie('username',$_username);
            setcookie('uniqid',$_uniqid);
            break;
        case '1':  //һ��
            setcookie('username',$_username,time()+86400);
            setcookie('uniqid',$_uniqid,time()+86400);
            break;
        case '2':  //һ��
            setcookie('username',$_username,time()+604800);
            setcookie('uniqid',$_uniqid,time()+604800);
            break;
        case '3':  //һ��
            setcookie('username',$_username,time()+2592000);
            setcookie('uniqid',$_uniqid,time()+2592000);
            break;
    }
}

/**
 * _check_username��ʾ��Ⲣ�����û���
 * @access public
 * @param string $_string ����Ⱦ���û���
 * @param int $_min_num  ��Сλ��
 * @param int $_max_num ���λ��
 * @return string  ���˺���û���
 */
function _check_username($_string,$_min_num,$_max_num) {
    //ȥ�����ߵĿո�
    $_string = trim($_string);

    //����С����λ���ߴ���20λ
    if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
        _alert_back('�û������Ȳ���С��'.$_min_num.'λ���ߴ���'.$_max_num.'λ');
    }

    //���������ַ�
    $_char_pattern = '/[<>\'\"\ \��]/';
    if (preg_match($_char_pattern,$_string)) {
        _alert_back('�û������ð��������ַ�');
    }

    //���û���ת������
    return _mysql_string($_string);
}


/**
 * _check_password��֤����
 * @access public
 * @param string $_first_pass
 * @param int $_min_num
 * @return string $_first_pass ����һ�����ܺ������
 */

function _check_password($_string,$_min_num) {
    //�ж�����
    if (strlen($_string) < $_min_num) {
        _alert_back('���벻��С��'.$_min_num.'λ��');
    }

    //�����뷵��
    return sha1($_string);
}


function _check_time($_string) {
    $_time = array('0','1','2','3');
    if (!in_array($_string,$_time)) {
        _alert_back('������ʽ����');
    }
    return _mysql_string($_string);
}

?>