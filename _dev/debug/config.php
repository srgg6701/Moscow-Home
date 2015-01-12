<?php
//
$section = $_GET['section'];
if (!$section) $section = 'default';
/**
 * Настройки подложки: */
$site_name = 'visavi';
define("HTTP_BASE_PATH", 'http://' . $_SERVER['HTTP_HOST'] . "/projects/" . $site_name . '/');
// Идентификатор главного тестируемого блока:
define("MAIN_BLOCK", "#page");
// Идентификатор блока с меню тестовых разделов
define("DEBUG_MENU", "debug-menu");
// Идентификатор ссылки для управления видимостью меню тестовых разделов
define("DEBUG_LINKS", "debug-links");
// Имя директори с изображениями
define("IMGS_DIR", "pixel-perfect");
// Путь расположения изображений относительно документа:
$substrate_path = HTTP_BASE_PATH . '_dev/debug/' . IMGS_DIR . '/';