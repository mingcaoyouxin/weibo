<?php
function _check_content($_string) {
    if (mb_strlen($_string,'utf-8') < 10 || mb_strlen($_string,'utf-8') > 200) {
        _alert_back('短信内容不得小于10位或者大于200位！');
    }
    return $_string;
}

?>