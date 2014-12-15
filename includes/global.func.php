<?php
/**
 *_runtime()��������ȡִ�к�ʱ
 * @access public  ��ʾ�������⹫��
 * @return float ��ʾ���س�������һ������������
 */
function _runtime() {
    $_mtime = explode(' ',microtime());
    return $_mtime[1] + $_mtime[0];
}
/**
 *����Ψһ��ʾ��
 */

function _sha1_uniqid() {
    return _mysql_string(sha1(uniqid(rand(),true)));
}
/**
 * _alert_back()����JS����
 * @access public
 * @param $_info
 * @return void ����
 */
function _alert_back($_info) {
    echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
    exit();
}
/**
 * _code()����֤�뺯��
 * @access public
 * @param int $_width ��ʾ��֤��ĳ���
 * @param int $_height ��ʾ��֤��ĸ߶�
 * @param int $_rnd_code ��ʾ��֤���λ��
 * @param bool $_flag ��ʾ��֤���Ƿ���Ҫ�߿�
 * @return void �������ִ�к����һ����֤��
 */
function _code($_width = 75,$_height = 25,$_rnd_code = 4,$_flag = false) {

    //���������
    for ($i=0;$i<$_rnd_code;$i++) {
        $_nmsg .= dechex(mt_rand(0,15));
    }

    //������session
    $_SESSION['code'] = $_nmsg;
    //����һ��ͼ��
    $_img = imagecreatetruecolor($_width,$_height);

    //��ɫ
    $_white = imagecolorallocate($_img,255,255,255);

    //���
    imagefill($_img,0,0,$_white);

    if ($_flag) {
        //��ɫ,�߿�
        $_black = imagecolorallocate($_img,0,0,0);
        imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
    }

    //�漴����6������
    for ($i=0;$i<6;$i++) {
        $_rnd_color = imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
    }

    //�漴ѩ��
    for ($i=0;$i<100;$i++) {
        $_rnd_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
        imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_rnd_color);
    }

    //�����֤��
    for ($i=0;$i<strlen($_SESSION['code']);$i++) {
        $_rnd_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
        imagestring($_img,5,$i*$_width/$_rnd_code+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
    }

    //���ͼ��
    header('Content-Type: image/png');
    imagepng($_img);

    //����
    imagedestroy($_img);
}
/**
 * _check_code
 * @param string $_first_code
 * @param string $_end_code
 * @return void ��֤��ȶ�
 */

function _check_code($_first_code,$_end_code) {
    if ($_first_code != $_end_code) {
        _alert_back('��֤�벻��ȷ!');
    }
}

/**
 * _mysql_string
 * @param string $_string
 * @return string $_string
 */

function _mysql_string($_string) {
	//get_magic_quotes_gpc()�������״̬����ô�Ͳ���Ҫת��
	if (!GPC) {
		if (is_array($_string)) {
			foreach ($_string as $_key => $_value) {
				$_string[$_key] = _mysql_string($_value);   //��������˵ݹ飬�������⣬��ô������htmlspecialchars
			}
		} else {
			$_string = mysql_real_escape_string($_string);
		}
	} 
	return $_string;
}

function _location($_info,$_url) {
    if (!empty($_info)) {
        echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
        exit();
        } else {
		header('Location:'.$_url);
	}
}

/**
 * _session_destroyɾ��session
 */

function _session_destroy() {
    session_destroy();
}

/**
 * _login_state��¼״̬���ж�
 */

function _login_state() {
	if (isset($_COOKIE['username'])) {
		_alert_back('��¼״̬�޷����б�������');
	}
}



/**
 * ɾ��cookies   _unsetcookies()
 */

function _unsetcookies() {
	setcookie('username','',time()-1);
	setcookie('uniqid','',time()-1);
	_session_destroy();
	_location(null,'index.php');
}


/**
 * 
 * @param $_sql
 * @param $_size
 */

function _page($_sql,$_size) {
	//����������б���ȡ�������ⲿ���Է���
	global $_page,$_pagesize,$_pagenum,$_pageabsolute,$_num;
	if (isset($_GET['page'])) {
		$_page = $_GET['page'];
		if (empty($_page) || $_page < 0 || !is_numeric($_page)) {
			$_page = 1;
		} else {
			$_page = intval($_page);
		}
	} else {
		$_page = 1;
	}
	$_pagesize = $_size;
	$_num = mysql_num_rows(_query($_sql));
	if ($_num == 0) {
		$_pageabsolute = 1;
	} else {
		$_pageabsolute = ceil($_num / $_pagesize);
	}
	if ($_page > $_pageabsolute) {
		$_page = $_pageabsolute;
	}
	$_pagenum = ($_page - 1) * $_pagesize;
}



/**
 * _paging��ҳ����
 * @param $_type
 * @return ���ط�ҳ
 */

function _paging($_type) {
    global $_page,$_pageabsolute,$_num;
    if ($_type == 1) {
        echo '<div id="page_num">';
        echo '<ul>';
        for ($i=0;$i<$_pageabsolute;$i++) {
            if ($_page == ($i+1)) {
                echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
            } else {
                echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'">'.($i+1).'</a></li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    } elseif ($_type == 2) {
        echo '<div id="page_text">';
        echo '<ul>';
        echo '<li>'.$_page.'/'.$_pageabsolute.'ҳ | </li>';
      
        if ($_page == 1) {
            echo '<li>��ҳ | </li>';
            echo '<li>��һҳ | </li>';
        } else {
            echo '<li><a href="'.SCRIPT.'.php">��ҳ</a> | </li>';
            echo '<li><a href="'.SCRIPT.'.php?page='.($_page-1).'">��һҳ</a> | </li>';
        }
        if ($_page == $_pageabsolute) {
            echo '<li>��һҳ | </li>';
            echo '<li>βҳ</li>';
        } else {
            echo '<li><a href="'.SCRIPT.'.php?page='.($_page+1).'">��һҳ</a> | </li>';
            echo '<li><a href="'.SCRIPT.'.php?page='.$_pageabsolute.'">βҳ</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}

function _alert_close($_info) {
    echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
    exit();
}
function _ubb($_string) {
    $_string = nl2br($_string);
    $_string = preg_replace('/\[(.*)\]/U','<img src="emoj/\1.gif" alt="ͼƬ" />',$_string);
    return $_string;
}

?>