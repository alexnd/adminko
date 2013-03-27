<?php defined('SYSPATH') or die('No direct script access.');
/*
 * generic implementation of Adminko driver
 * */

class Kohana_Adminko_Generic extends Adminko {

    protected $_data = array();
    protected $_viewable = true;
    protected $_jsonable = true;
    protected $_use_layout = true;

    //TODO: implement
    public function process_node_editor($node)
    {
        //if( 'POST' == strtoupper( Request::initial()->method() ) ) {
        if( 'POST' == Request::initial()->method() ) {
            $this->_viewable = false;
            if($node) {
                $content = Request::initial()->post('content');
                Adminko::$_cmsko->save($node, $content);
                echo $content;
                $this->_jsonable = false;
            }
            else {
                $this->_data['processed'] = false;
            }
        }
        else {
            if(Request::initial()->is_ajax()) $this->_use_layout = false;
        }
    }
    
    public function render_node($node, $is_editor = true)
    {
        return ($is_editor) ? Adminko::render_button_view( $node, null, Adminko::$_cmsko->load($node) )
            : Adminko::$_cmsko->load($node);
    }


    public function render_node_button($node, $type = null, $content = null)
    {
        return Adminko::render_button_view( $node, $type, $content );
    }

    public function render_node_editor($node)
    {
        if($this->_viewable) {
            if($this->_use_layout) Adminko::init_layout_view();
            //TODO: rename view to editor.php
            $view_edit = View::factory('adminko/edit');
            $view_edit->set('content', Adminko::$_cmsko->load($node));
            $view_edit->set('id', $node);
            if($this->_use_layout) {
                Adminko::$_layout_view->set('content', $view_edit->render());
                return Adminko::$_layout_view->render();
            }
            else {
                return $view_edit->render();
            }
        }
        else if($this->_jsonable) {
            return json_encode($this->_data);
        }
    }
}
