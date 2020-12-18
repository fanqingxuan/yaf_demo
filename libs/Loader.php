<?php

class Loader {

    public static function loadClass($className) {
        $dirList = [
            'services',
            'models',
        ];
        foreach($dirList as $dir) {

            $fileName = APPLICATION_PATH.$dir.'/'.$className.'.php';
            if(file_exists($fileName)) {
                require_once($fileName);
            }
        }
    }
}