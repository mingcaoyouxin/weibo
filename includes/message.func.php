<?php
function _check_content($_string) {
    if (mb_strlen($_string,'utf-8') < 10 || mb_strlen($_string,'utf-8') > 200) {
        _alert_back('�������ݲ���С��10λ���ߴ���200λ��');
    }
    return $_string;
}

?>