Adminko - Admin for Kohana
==========================

Admin tools for Kohana3. Depends on [Cmsko](https://github.com/alexmav/cmsko).

There is development state. Some usage cases and design flow.

Functionality
-------------

* Cover the [Cmsko](https://github.com/alexmav/cmsko)
* Extends base Controller
* Inline cms fields in Views
* Base ui widgets on [Twitter Bootstrap](https://github.com/twitter/bootstrap), [Tinymce](https://github.com/tinymce/tinymce)
* Javascript side based on [JQuery](https://github.com/jquery/jquery)
* 'jsonable' mode
* CRUD views
* Admin toolbar view
* Widgets for administration of: users (based on model from Kohana box) and content nodes (from Cmsko)

Module structure
----------------

* REAMDE.md - this file
* init.php
* config/adminko.php
* classes/Adminko.php
* classes/Adminko/<driver>.php
* classes/Kohana/Adminko.php
* classes/Kohana/Adminko/<driver>.php
* classes/Kohana/Adminko/Controller/Admin.php
* classes/Model/Adminko/Role.php
* classes/Model/Adminko/User.php
* views/adminko/button.php
* views/adminko/edit.php
* views/adminko/modal-container.php
* views/adminko/modal-layout.php
* media/js/adminko.js
* media/css/adminko.css

How to use
----------

1. Set up both Adminko and [Cmsko](https://github.com/alexmav/cmsko) modules adding they as git submodules or just unpack archives in your _modules_ dir.
2. Extends User and Role models, and class Adminko, if necessary. Take a look to their code there first to make decision if this module meets your way :) A minimal path to solve our task - is use special role 'admin' defined in class Model_Adminko_Role. Than we just make query in User model to make comparison is user has this role. To change this behaviour in your way - you must as minimum extends class Adminko to write your own method check_user_admin()
3. Place media/js/adminko.js in document root (you may walnt symlink it or make any proper mapping in your web server).
4. Make copy of config/adminko.php to your application dir and make all proper settings.
5. Include #basic-modal-content element in your page's DOM (or make the proper way to inject it at the page loading time):
   ```html
   <div id="basic-modal-content" style="display:none"></div>
   ```
6. Include adminko.js and adminko.css in your pages. For example, in this way:
   ```php
   $this->view->scripts[] = '/js/adminko.js';
   $this->view->styles[] = '/js/adminko.js';
   ```
   You may use triggering technique, depending on user role is admin or not, as described below.
7. In before() filter of your base controller class:
   ```php
   // this is, for example, your admin role trigger implementation
   $this->admin_mode = ($this->logged_in && $this->current_user->is_admin);

   // make Adminko instance
   $this->admin = Adminko::instance(0);
   ```
8. In actions, where admin functions should be:
   ```php
   // set 'is admin' to view
   $this->view->set('admin_mode', $this->admin_mode);

   // set cms field (button appended or just content if not in admin role)
   $this->view->set('content', $this->admin->render_node('my_id', $this->admin_mode));
   ```
9. In actions, where only content needed:
   ```php
   // set some cms value using underlying Cmsko instance
   $this->view->set('content_js', Kohana_Adminko::$_cmsko->load('my_id_js'));
   ```

TODO
----

1. Implementation the rest of things :)
2. Switching 'edit mode' by cookie/session var (may be turned on|off by adding extra param 'editmode=1' in GET/COOKIE)
3. Make a way to not depend of JQuery and Bootstrap