<?php
function my_autoload($class_name) 
{
    $dir_util = './class/util/';
    if (is_file($dir_util.'class.'.$class_name.'.php')) {
        require_once $dir_util.'class.'.$class_name.'.php';
    }
    $dir_util = '../class/util/';
    if (is_file($dir_util.'class.'.$class_name.'.php')) {
        require_once $dir_util.'class.'.$class_name.'.php';
    }
    $dir_util = '../../class/util/';
    if (is_file($dir_util.'class.'.$class_name.'.php')) {
        require_once $dir_util.'class.'.$class_name.'.php';
    }
    // ---------------------------------------------------
    $dir_dao = './class/dao/';
    if (is_file($dir_dao.'class.'.$class_name.'.php')) {
        require_once $dir_dao.'class.'.$class_name.'.php';
    }
    $dir_dao = '../class/dao/';
    if (is_file($dir_dao.'class.'.$class_name.'.php')) {
        require_once $dir_dao.'class.'.$class_name.'.php';
    }
    $dir_dao = '../../class/dao/';
    if (is_file($dir_dao.'class.'.$class_name.'.php')) {
        require_once $dir_dao.'class.'.$class_name.'.php';
    }
    // ---------------------------------------------------
    $dir_entity = './class/entity/'; 
    if (is_file($dir_entity.'class.'.$class_name.'.php')) {
        require_once $dir_entity.'class.'.$class_name.'.php';
    }
    $dir_entity = '../class/entity/'; 
    if (is_file($dir_entity.'class.'.$class_name.'.php')) {
        require_once $dir_entity.'class.'.$class_name.'.php';
    }
    $dir_entity = '../../class/entity/'; 
    if (is_file($dir_entity.'class.'.$class_name.'.php')) {
        require_once $dir_entity.'class.'.$class_name.'.php';
    }
    // ---------------------------------------------------
    $dir_repository = './class/repository/';
    if (is_file($dir_repository.'class.'.$class_name.'.php')) {
        require_once $dir_repository.'class.'.$class_name.'.php';
    }
    $dir_repository = '../class/repository/';
    if (is_file($dir_repository.'class.'.$class_name.'.php')) {
        require_once $dir_repository.'class.'.$class_name.'.php';
    }
    $dir_repository = '../../class/repository/';
    if (is_file($dir_repository.'class.'.$class_name.'.php')) {
        require_once $dir_repository.'class.'.$class_name.'.php';
    }
    // ---------------------------------------------------
    $dir_service = './class/service/';
    if (is_file($dir_service.'class.'.$class_name.'.php')) {
        require_once $dir_service.'class.'.$class_name.'.php';
    }
    $dir_service = '../class/service/';
    if (is_file($dir_service.'class.'.$class_name.'.php')) {
        require_once $dir_service.'class.'.$class_name.'.php';
    }
    $dir_service = '../../class/service/';
    if (is_file($dir_service.'class.'.$class_name.'.php')) {
        require_once $dir_service.'class.'.$class_name.'.php';
    }
    // ---------------------------------------------------
    $dir_controller = './class/controller/';
    if (is_file($dir_controller.'class.'.$class_name.'.php')) {
        require_once $dir_controller.'class.'.$class_name.'.php';
    }
    $dir_controller = '../class/controller/';
    if (is_file($dir_controller.'class.'.$class_name.'.php')) {
        require_once $dir_controller.'class.'.$class_name.'.php';
    }
    $dir_controller = '../../class/controller/';
    if (is_file($dir_controller.'class.'.$class_name.'.php')) {
        require_once $dir_controller.'class.'.$class_name.'.php';
    }
}
spl_autoload_register("my_autoload");
?>