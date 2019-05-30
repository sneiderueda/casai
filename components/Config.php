<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Config{
    private static $request=null;
    public static function  getBaseurl(){
        $request=$_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'];
        $explodeUrl=explode('/',$request);
        return  self::$request=$explodeUrl[4];
    }
    
}
?>
