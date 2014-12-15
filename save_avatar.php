<?php
define('SD_ROOT', dirname(__FILE__).'/');
@header("Expires: 0");
@header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");

//���ﴫ���������������ͣ�һ��һ��, big��small, ����ɹ��󷵻�һ��json�ִ����ͻ��˻��ٴ�post��һ��.
$type = isset($_GET['type'])?trim($_GET['type']):'small';
$pic_id = trim($_GET['photoId']);
//$orgin_pic_path = $_GET['photoServer']; //ԭʼͼƬ��ַ������.
//$from = $_GET['from']; //ԭʼͼƬ��ַ������.

//����ͼƬ���·��
$new_avatar_path = 'avatar_'.$type.'/'.$pic_id.'_'.$type.'.jpg';

//��POST�����Ķ���������ֱ��д��ͼƬ�ļ�.
$len = file_put_contents(SD_ROOT.'./'.$new_avatar_path,file_get_contents("php://input"));

//ԭʼͼƬ�Ƚϴ�ѹ��һ��. Ч�����Ǻ����Ե�, ʹ��80%��ѹ�������ۻ���û��ʲô����
//СͼƬ ��ѹ��Լ6K, ѹ���� 2K, ��ͼƬԼ 50K, ѹ���� 10K
$avtar_img = imagecreatefromjpeg(SD_ROOT.'./'.$new_avatar_path);
imagejpeg($avtar_img,SD_ROOT.'./'.$new_avatar_path,80);
//nixϵͳ���б�Ҫʱ����ʹ�� chmod($filename,$permissions);

log_result('ͼƬ��С: '.$len);


//����±����ͼƬλ��, ����ʱע���һ������·��, �����statusText�ǳɹ���ʾ��Ϣ.
//status Ϊ1 �ǳɹ��ϴ�������Ϊʧ��.
$d = new pic_data();
//$d->data->urls[0] = 'http://sns.com/avatar_test/'.$new_avatar_path;
$d->data->urls[0] = '/avatar_test/'.$new_avatar_path;
$d->status = 1;
$d->statusText = '�ϴ��ɹ�!';

$msg = json_encode($d);

echo $msg;

log_result($msg);
function  log_result($word) {
	@$fp = fopen("log.txt","a");	
	@flock($fp, LOCK_EX) ;
	@fwrite($fp,$word."��ִ�����ڣ�".strftime("%Y%m%d%H%I%S",time())."\r\n");
	@flock($fp, LOCK_UN); 
	@fclose($fp);
}
class pic_data
{
	 public $data;
	 public $status;
	 public $statusText;
	public function __construct()
	{
		$this->data->urls = array();
	}
}

?>