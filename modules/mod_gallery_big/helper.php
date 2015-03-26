<?php
// No direct access
defined('_JEXEC') or die('Restricted access'); 
/**
 * получим методы основного класса:
 */
class modModule_Gallery_bigHelper extends JModuleHelper
{
    static function getData(&$params){
        return $params->get( 'headers' );
    }
}