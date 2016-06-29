<?php
/**
 * Smarty function to load js scripts
 * 
 * @param   array   $args   Array of arguments
 * @param   mixed   $smarty Smarty Object
 * @return  string
 */
function smarty_function_load_js($args, &$smarty) {
    if(empty($args["script"]))
        return "";
    $file = Utilities::includeJS($args["script"]);
    return $file != "" ? '<script type="text/javascript" src="' . $file . '"></script>' : "";
}
?>