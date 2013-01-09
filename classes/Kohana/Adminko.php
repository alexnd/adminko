<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Kohana_Adminko {

    // Adminko instances
    protected static $_singleton;
    protected static $_instances = array();

    protected $_config;
    protected $_id;

    protected $_data = array();

    public static $_cmsko;

    protected static $_layout_view;
    protected static $_button_view;
    protected static $_container_view;

    public static $is_developer = false;

    public function __construct($id, $config = array())
    {
        $this->_id = $id;
        $this->_config = $config;
    }

    /**
     * Adminko singleton (for module init)
     *
     * @return Adminko
     */
    public static function instance($config = null)
    {
        // support for 1-array param usage
        if( is_array($config) && array_key_exists('id', $config) && is_scalar($config['id']) )
        {
            return Adminko::factory($config['id'], $config);
        }
        else
        {
            if ( !isset(Adminko::$_singleton) )
            {
                if( !(is_string($config) && strlen($config)) )
                {
                    $config = 'cmsko';
                }
                $config = Kohana::$config->load($config);
                if(!is_array($config)) {
                    //$config = $config->get('router');
                }
                $type = isset($config['driver']) ? $config['driver'] : 'generic';
                //TODO: try-catch ?
                $class = 'Adminko_'.ucfirst($type);
                Adminko::$_singleton = new $class($config);
                Adminko::init_cmsko();
                Adminko::check_edit_mode();
            }
            return Adminko::$_singleton;
        }
    }

    /**
     * Adminko instances factory method
     *
     * @return Adminko
     */
    public static function factory($id = null, $config = null)
    {
        if ( is_scalar($id) )
        {
            if ( !isset(Adminko::$_instances[$id]) )
            {
                //TODO: refactor config- stuff
                if ( is_scalar($config) )
                {
                    $config = Kohana::$config->load($config);
                    if(!is_array($config)) {
                        $config = $config->get('cms_nodes');
                    }
                }
                if ( is_array($config) )
                {
                    $type = isset($config['driver']) ? $config['driver'] : 'generic';
                }
                else
                {
                    //TODO: what is that? why we here...
                    $type = 'generic';
                }
                //TODO: try-catch ?
                $class = 'Adminko_'.ucfirst($type);
                Adminko::$_instances[$id] = new $class($id, $config);
                Adminko::init_cmsko();
                Adminko::check_edit_mode();
            }
            return Adminko::$_instances[$id];
        }
    }

    //init basic cms layer driver
    //TODO: tweak storage type here
    public static function init_cmsko() {
        if( !isset(Adminko::$_cmsko) ) Adminko::$_cmsko = Cmsko::instance(0);
    }

    public function get_id()
    {
        return $this->_id;
    }

    //construct the view only once
    public static function init_layout_view()
    {
        if( !isset(Adminko::$_layout_view) ) {
            Adminko::$_layout_view = View::factory("adminko/modal-layout");
            Adminko::$_layout_view->set('styles', array(0 => "/css/admin.css"));
            Adminko::$_layout_view->set('scripts', array("/js/jquery-1.8.2.js",
                "/js/jquery.simplemodal-1.4.2.js",
                "/js/admin.js"));
        }
    }

    //rendering of edit control
    public static function render_button_view($id, $type = null, $content = null)
    {
        //construct the view only once
        if( !isset(Adminko::$_button_view) ) Adminko::$_button_view = View::factory("adminko/button");
        Adminko::$_button_view->set('type', $type);
        Adminko::$_button_view->set('content', $content);
        Adminko::$_button_view->set('id', $id);
        return Adminko::$_button_view->render();
    }

    //TODO: move here some common things from Generic subclass

    //display node with editor button (button displayed if necessary)
    abstract function render_node($node);

    //display editor view for node
    abstract function render_node_editor($node);

    //display only button for node (if necessary)
    abstract function render_node_button($node);

    //display floating half-transparented toolbar with some useful admin functions
    //abstract function render_toolbar();

    //display container for modal windows functionality
    public static function render_modal_container()
    {
        if( !isset(Adminko::$_container_view) ) Adminko::$_container_view = View::factory("adminko/modal-container");
        return Adminko::$_container_view->render();
    }

    //process updating node content (if necessary)
    abstract function process_node_editor($node);

    //determines possibility to view edit-mode controls (get/cookie developer switcher
    public static function check_edit_mode()
    {
        if(isset($_GET['developer'])) {
            if($_GET['developer']) {
                Cookie::set('developer', '1');
                Adminko::$is_developer = true;
            }else{
                Cookie::delete('developer');
                Adminko::$is_developer = false;
            }
        }
        else {
            Adminko::$is_developer = ( '1' == trim(Cookie::get('developer', '')) ) ? true : false;
        }
    }

} // End Adminko
