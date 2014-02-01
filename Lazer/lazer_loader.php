<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

    function __autoload($className)
    {
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
        }

        // Set CI_Exceptions place
        if($className == 'CI_Exceptions')
            $fileName .= DOCPATH . SYSDIR . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR .  str_replace('CI_', '', $className).'.php';
        else
            $fileName = MODPATH . MY_MODPATH . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . $fileName .  str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';

        require $fileName;
    }