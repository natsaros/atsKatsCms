<?php
require_once(COMMON_ROOT_PATH . 'compiler/lessc.inc.php');
$less = new lessc;
$less->setFormatter("compressed");
$less->checkedCompile('./admin/assets/css/adminCustom.less', './admin/assets/css/adminCustom.css');