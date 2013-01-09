Adminko
=======

Admin toolbar for Kohana3. Depends on Cmsko.

There is development state. Some usage cases and design flow.

In before filter
```php
$this->admin = Adminko::instance(0);
$this->admin_mode = ($this->logged_in && $this->current_user->is_admin && Adminko::$is_developer);
```

In action
```php
$this->view->set('admin_mode', $this->admin_mode);
if( $this->admin_mode ) {
    $this->view->set('content', $this->admin->render_node('my_id'));
}
else { //draw without button
    $this->view->set('content', $this->admin->render_node('my_id', false));
}
$this->view->set('content_js', Kohana_Adminko::$_cmsko->load('my_id_js'));
```

[admin toolbar]

[base ui widgets]

[utilizes cmsko]

[crud for orm]

[skinning]
