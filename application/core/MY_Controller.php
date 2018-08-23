<?php
/**
* This library extends the default controller and adds some useful extra features.
* Features:
*         1. Enables the usage of master page/templates.
*         2. Can add css and javascript files.
*         3. Uses the _output method for controling the controllers output.
*         4. Can load relative content with in the form of modules (views)
*/
class MY_Controller extends CI_Controller {
    /* Output control constants */
    const OUTPUT_TEMPLATE = 10;
    const OUTPUT_NORMAL = 11;

    /* Private properties */

    //the default template
    private $template_view = 'default';
    
    //the default public folder this means that content inside this folder will be accessed directly
    //without using the routing.
    //Note!!! This folder must be enabled in the .htaccess file.
    private $public_folder = 'public/';
    
    //the default location for the templates inside the views folder this means (views/templates/)
    private $template_folder = 'templates/';
    
    //the default css location for the css files inside the $public_folder("public/" by default) (public/css/)
    private $css_folder = 'css/';
    
    //the default js location for the css files inside the $public_folder("public/" by default) (public/js/)
    private $js_folder = 'js/';
    
    //Inline scripting (Javascript)
    private $inline_scripting = '';

    private $modules = array(); //An array that contains the modules output.

    private $charset = ''; //The page charset

    private $title = ''; //The page Title

    //Media files and data
    private $media = array('css'=>array(),
                            'js'=>array(),
                             //meta tags
                            'meta'=>array(),
                            //fbimg
                            'fbimg'=>array(),
                             //RDF are 3rd genreration meta tags
                            'rdf'=>array());

    //The requested controller
    protected $controller = '';
    //The requested method to be called
    protected $method        = '';
    
    private $_output_data = array();

    /**
     * The MY_Controller constructor method.
     */
    function __construct(){
        parent::__construct();
                
        //Initializing the controller
        //Get the default charset from the config file.
        $this->charset = $this->config->item('charset');

        //Set the default mode to use a template view
        $this->_setOutputMode(self::OUTPUT_TEMPLATE);

        //Passing as properties the controller and the method that should be called.
        $this->controller = $this->uri->rsegment(1);
        $this->method      = $this->uri->rsegment(2);
    }

    /**
     * CodeIgniter magic method that controls the output of a controller.
     * You can't call it directly.
     *
     * @see http://codeigniter.com/user_guide/general/controllers.html#output
     * @final this method cannot be overloaded
     * @param string $output the controller output
     * @return void
     */
    final function _output($output){
        switch($this->mode){
            //Use the template
            case self::OUTPUT_TEMPLATE:
                $data = array(    'meta'=>$this->media['meta'],
                                'rdf'=>$this->media['rdf'],
                                'js'=>$this->media['js'],
                                'css'=>$this->media['css'],
                                'fbimg'=>$this->media['fbimg'],
                                'title'=>$this->title,
                                'charset'=>$this->charset,
                                'output'=>$output,
                                'modules'=>(object)$this->modules,
                                'inline_scripting'=>"<script type='text/javascript'>" . $this->inline_scripting . "</script>");
                
                //Merge the data arrays
                $data = array_merge($data, $this->_output_data);
                
                //Load the final output
                $out = $this->load->view($this->template_folder . $this->template_view, $data, TRUE);
                
                //The End
                echo $out;
            break;
            //or just echo output.
            case self::OUTPUT_NORMAL:
            default:
                echo $output;
            break;
        }
    }
    
    /**
     * Pass extra data on the final output.
     *
     * @param string $paramName the parameter name.
     * @param mixed $value $the value of the parameter
     */
    
    protected function _setOutputData($paramName, $value){
        $this->_output_data[$paramName] = $value;
    }

    /**
     * This method sets the output mode. That the controller should use to display the content
     *
     * @access protected
     * @param int $mode One of the constants self::OUTPUT_TEMPLATE, self::OUTPUT_NORMAL
     * @return void
     */
    protected function _setOutputMode($mode){
        $this->mode = $mode;
    }
    
    /**
     * Sets the template that will be used at the final output.
     *
     * @access protected
     * @param string $template
     * @return bool
     */
    public function _template_to_use($template){
        $filepath = APPPATH . "views/"  . $this->template_folder . str_replace('.php','',$template) . ".php";
                
        if(!$this->_is_file_exists($filepath)){
            show_error("Cannot locate template file <tt>$template</tt>");
            return false;
        }

        $this->template_view = $template;
        
        return true;
    }

    /**
     * Adds a Javascript file into the template.
     *
     * @access protected
     * @param string $file a js file located inside the public/js/ folder or an url.
     * @param boolean $custom_url Default FALSE. A flag to determine if the given $file is an url or just a file inside the public/js/ folder.
     * @return bool
     */
    public function _add_js_file($file, $custom_url=false){
        
        if($custom_url===false){
            $filepath = $this->public_folder . $this->js_folder . str_replace('.js','',$file) . ".js";
                    
            if(!$this->_is_file_exists($filepath)){
                show_error('Cannot locate javascript file <tt><a href="'.$filepath.'">'.$filepath.'</a></tt>');
                return false;
            }
            
            $filepath = base_url() . $filepath;
            
        }else{
            $filepath = $file;
        }
        
        if (array_search($filepath, $this->media['js']) === false)
            $this->media['js'][] = $filepath;
        else
            return false;
            
        return true;
    }
    
    /**
     * Adds a CSS file into the template.
     *
     * @access protected
     * @param string $file a css file located inside the public/js/ folder or an url.
     * @param boolean $custom_url Default FALSE. A flag to determine if the given $file is an url or just a file insite the public/js/ folder.
     * @return bool
     */
    public function _add_css_file($file, $custom_url=false){
        if(!$custom_url){
            
            // OLD: $filepath = $this->public_folder . $this->css_folder . str_replace('.css','',$file) . ".css";
            $filepath = $this->public_folder . $this->css_folder . str_replace('.css','',$file) . ".css";
            if(!$this->_is_file_exists($filepath)){
                show_error('Cannot locate css file: <tt><a href="'.$filepath.'">'.$filepath.'</a></tt>');
                return false;
            }
            
            // OLD: $filepath = base_url() . $filepath;
            $filepath = $filepath;
        }else{
            $filepath = $file;
        }

        if(array_search($filepath, $this->media['css']) === false)
            $this->media['css'][] = $filepath;
        else return false;
        
        return true;
    }
    
    public function _add_fbimg ($file){
        $this->media['fbimg'][] = base_url().$file;
    }

    /**
     * Sets the default charset
     *
     * @access protected
     * @param string $charset
     * @return void
     */
    public function _set_chartset($charset){
        $this->charset = $charset;
    }

    /**
     * Sets the page title
     *
     * @access protected
     * @param string $new_title
     * @return void
     */
    public function _set_title($new_title){
        $this->title = $new_title;
    }

    /**
     * Appends a string at the title text
     *
     * @access protected
     * @param string $title
     * @return void
     */
    public function _append_title($title){
        $this->title .= " - $title";
    }

    /**
     * Adds meta tags.
     *
     * @access protected
     * @param string $name the name of the meta tag
     * @param string $content the content of the mneta tag
     * @return bool
     */
    public function _add_meta($name, $content){
        if(array_key_exists($name, $this->media['meta']))
            show_error("Duplicate usage of meta tag file <tt>$name</tt>.");

        $this->media['meta'][$name] = $content;
        return true;
    }

    /**
     * Adds RDF meta tags (3rd generation meta tags).
     *
     * @access protected
     * @param string $name the name of the meta tag
     * @param string $content the content of the mneta tag
     * @return bool
     */
    public function _add_RDF($name, $content){
        if(array_key_exists($name, $this->media['rdf']))
            show_error("Duplicate usage of meta tag file <tt>$name</tt>.");

        $this->media['rdf'][$name] = $content;
        return true;
    }

    /**
     * Registers module positions
     *
     * @access protected
     * @param string $position_name the name of the position (no special chars or spaces are allowed)
     * @return bool
     */
    public function _register_module_position($position_name){
        if(array_key_exists($position_name, $this->modules))
            show_error("Module position failed because position <tt>$position_name</tt> has already been registered.");

        //Check for illegal characters.
        if(!preg_match("/[a-zA-Z0-9]*/", $position_name))
            show_error("Position name <tt>$position_name</tt> contains some illegal characters. Only letters or numbers are allowed.");

        $this->modules[$position_name] = array();

        return true;
    }
    
    /**
     *    Loads a view file (module) in a certain position.
     *
     * @access protected
     * @param string $position the module position
     * @param string $view_file the view file path.
     * @param array $params    the parameter to be passed in the view file.
     * @return bool
     */
    public function _load_module($position, $view_file, $params = array()){
        if(!array_key_exists($position, $this->modules))
            show_error("Module position <tt>$position</tt> hasn't ever been registered.");
        
        $this->modules[$position][] = $this->load->view($view_file, $params, TRUE);
        
        return true;
    }

    /**
     * Marks the begining of inline scripting.
     * Example:
     *     <?php ....
     *
     *             $this->_start_inline_scripting();
     *     ?>
     *     <script> .... </script>
     *  <?php
     *         $this->_end_inline_scripting();
     *     .....
     *!!!Note that the <scrpt*></script> tags will be removed!!!
     *
     */
    public function _start_inline_scripting(){
        ob_start();
    }

    /**
     * Marks the end of the inline scripting.
     */
    public function _end_inline_scripting(){
         $s = ob_get_clean();
         
         $s = preg_replace("/[removed]]*>/", '', $s);
         $s = preg_replace("/<\/script>/", '', $s);
              
         $this->inline_scripting .= $s;
    }
    

    /**
     * Checks if the given file exists in the filesystem.
     *
     * @access private
     * @param string $filepath The file path, using a physical relative path
     * @return bool
     */
    private function _is_file_exists($filepath){
        return file_exists($filepath);
    }
}
