<?php
require_once(COMMON_ROOT_PATH . 'compiler/lessc.inc.php');
$less = new lessc;
$less->setFormatter("compressed");
$less->checkedCompile('./assets/css/adminCustom.less', './assets/css/adminCustom.css');