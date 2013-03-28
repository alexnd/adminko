<?php defined('SYSPATH') or die('No direct script access.');

//TODO: rename class to Kohana_Controller_Adminko

class Kohana_Controller_Adminko extends Controller
{
    public $logged_in = FALSE;
    public $current_user = NULL;
    protected $adminko = NULL;

    function __construct(Request $request, Response $response) {
        parent::__construct($request, $response);
        $this->adminko = Adminko::factory(0);
    }


/*public function before()
    {
        $this->logged_in = Auth::instance()->logged_in();
        $this->current_user = Auth::instance()->get_user();
        if( $this->logged_in && $this->current_user->is_admin && Adminko::$is_developer ) {

        }
        parent::before();
    }*/

    //public function after(){
        //if( 'login' == $this->request->action() ) {}
        //$this->view->set('logged_in', $this->logged_in);
        //$this->view->set('current_user', $this->current_user);
        //parent::after();
    //}

	
	public function action_index() {
		echo 'adminko panel todo, checking: '.Adminko::check_user_admin();
        //$view = View::factory('adminko/edit');
        //echo $view->render();
	}


    public function action_editor() {
        //TODO: find the way to solve it INDEPENDENTLY of ->current_user->is_admin
        //if( $this->logged_in && $this->current_user->is_admin && Adminko::$is_developer ) {
        if( Adminko::check_user_admin() ) {
            $id = $this->request->param('id');
            if( $this->request->query('content') ) {
                echo Kohana_Adminko::$_cmsko->load($id);
            }
            else {
                $this->adminko->process_node_editor($id);
                echo $this->adminko->render_node_editor($id);
            }
        }
    }


    //public function action_login() {}
	
}