<?php
//
$section = $_GET['section'];
if (!$section) $section = 'default';
$site_name = 'moscow-home';
/**
 * Настройки подложки: */
define("HTTP_BASE_PATH", 'http://' . $_SERVER['HTTP_HOST'] . "/projects/" . $site_name . '/');
// Идентификатор главного тестируемого блока:
define("MAIN_BLOCK", "#page");
// ID блока с подложкой
define("SUBSTRATE_ID", "#substrate");
//
define("SUBSTRATE_WRAPPER_ID", "#substrate-wrapper");
//
define("SUBSTRATE_RANGES_ID", "#substrate-ranges");
// Элементы управления
define("CONTROLS_ID", "#controls");
//
define("LBL_SBSTR_ID", "#lbl-sbstr");
//
define("OPACITY_RANGE_ID", "#opacity-range");
//
define("OPACITY_RANGE_CONTENT_ID", "#opacity-range-content");
// Идентификатор блока с меню тестовых разделов
define("DEBUG_MENU", "debug-menu");
// Идентификатор ссылки для управления видимостью меню тестовых разделов
define("DEBUG_LINKS", "debug-links");
define("DEBUG_LINKS_ID", "#" . DEBUG_LINKS);
// Имя директори с изображениями
define("IMGS_DIR", "pixel-perfect");
// Путь расположения изображений относительно документа:
$substrate_path = HTTP_BASE_PATH . '_dev/debug/' . IMGS_DIR . '/';
// показывать(?) подложку
$show_substrate = true;
// Отобразить линейку
$test_rulers = 'test_css';