<?php

//��ֹ�������
if (!defined('IN_TG')) {
    exit('Access Defined!');
}

//�����ַ�������
header('Content-Type: text/html; charset=gbk');

//ת��Ӳ·������
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//����һ���Զ�ת��״̬�ĳ������ж��Ƿ��Զ�ת��
define('GPC',get_magic_quotes_gpc());

//�ܾ�PHP�Ͱ汾
if (PHP_VERSION < '4.1.0') {
    exit('Version is to Low!');
}

//���뺯����
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

//ִ�к�ʱ
define('START_TIME',_runtime());
//$GLOBALS['start_time'] = _runtime();

//���ݿ�����
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','111111');
define('DB_NAME','weibo');

//��ʼ�����ݿ�
_connect();   //����MYSQL���ݿ�
_select_db();   //ѡ��ָ�������ݿ�
_set_names();   //�����ַ���

?>