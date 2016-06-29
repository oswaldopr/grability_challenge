<?php
/**
 * Class for utilities (static) functions
 * 
 * @author  Oswaldo Peña <oswaldopr@gmail.com>
 */
final class Utilities {

    /**
     * Gets the path to include a file or directory
     * 
     * @param   string  $dir        Name of directory to include
     * @param   string  $file       Name of file to include
     * @param   boolean $relative   Build the path as relative or absolute
     * @return  string
     */
    static public function getPath($dir, $file, $relative = true) {
        $separator = "/";
        $path = "";
        if(!$relative) {
            $separator = DIRECTORY_SEPARATOR;
            $path = dirname(__FILE__) . $separator;
        }
        $fullPath = $path . $dir . $separator . $file;
        if(!file_exists($fullPath)) {
            $fullPath = $path . ".." . $separator . $dir . $separator . $file;
            if(!file_exists($fullPath))
                $fullPath = "";
        }
        return $fullPath;
    }

    /**
     * Gets the path to include a controller file
     * 
     * @param   string  $controller Name of controller to include
     * @return  string
     */
    static public function includeController($controller) {
        return self::getPath("controls", $controller . CONTROL_EXTENSION);
    }

    /**
     * Gets the path to include a javascript file
     * 
     * @param   string  $jsScript   Name of js script to include
     * @return  string
     */
    static public function includeJS($jsScript) {
        return self::getPath("js", $jsScript . JS_EXTENSION);
    }

    /**
     * Gets the path to include a style sheet file
     * 
     * @param   string  $cssScript  Name of css script to include
     * @return  string
     */
    static public function includeCSS($cssScript) {
        return self::getPath("css", $cssScript . CSS_EXTENSION);
    }
}
?>