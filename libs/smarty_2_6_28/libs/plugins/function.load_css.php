<?php
/**
 * Smarty function to load css scripts
 * 
 * @param   array   $args   Array of arguments
 * @param   mixed   $smarty Smarty Object
 * @return  string
 */
function smarty_function_load_css($args, &$smarty) {
    if(empty($args["sheet"]))
        return "";
    $file = Utilities::includeCSS($args["sheet"]);
    return $file != "" ? '<link type="text/css" rel="stylesheet" href="' . $file . '" />' : "";
}
?>