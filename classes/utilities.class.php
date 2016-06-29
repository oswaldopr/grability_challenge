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
}
?>