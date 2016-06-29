<?php
/**
 * Class for templates (Smarty)
 * 
 * @author  Oswaldo Peña <oswaldopr@gmail.com>
 */
class Template extends Smarty {

    //--Class Properties--//
    private $_template;

    /**
     * Constructor of class
     * 
     * @param   string  $template   Name of template file
     * @return  void
     */
    public function __construct($template) {
        $this->Smarty();
        $this->template_dir = Utilities::getPath(SMARTY_TEMPLATES, "", false);
        $this->compile_dir = Utilities::getPath(SMARTY_TEMPLATES_C, "", false);
        $this->config_dir = Utilities::getPath(SMARTY_CONFIGS, "", false);
        $this->cache_dir = Utilities::getPath(SMARTY_CACHE, "", false);
        $this->compile_check = true;
        $this->caching = false;
        $this->_template = $template;
        $this->includeAppData();
        $this->includeTemplateCSS();
        $this->includeTemplateJS();
        $this->includeControllerFileName();
    }

    /**
     * Includes the name and project of application
     * 
     * @return  void
     */
    private function includeAppData() {
        $this->assign("appName", APP_NAME);
        $this->assign("appProject", APP_PROJECT);
    }

    /**
     * Includes the css script for template
     * 
     * @return  void
     */
    private function includeTemplateCSS() {
        $file = Utilities::includeCSS($this->_template);
        if($file != "") {
            $script = '<link type="text/css" rel="stylesheet" href="' . $file . '" />';
            $this->assign("templateCSS", $script);
        }
    }

    /**
     * Includes the javascript script for template
     * 
     * @return  void
     */
    private function includeTemplateJS() {
        $file = Utilities::includeJS($this->_template);
        if($file != "") {
            $script = '<script type="text/javascript" src="' . $file . '"></script>';
            $this->assign("templateJS", $script);
        }
    }

    /**
     * Includes the name of controller
     * 
     * @return  void
     */
    private function includeControllerFileName() {
        $controller = '<input type="hidden" id="hfController" value="' . basename($_SERVER["PHP_SELF"]) . '" />';
        $this->assign("controller", $controller);
    }

    /**
     * Displays the template
     * 
     * @return  void
     */
    public function display() {
        parent::display($this->_template . TEMPLATE_EXTENSION);
    }
}
?>