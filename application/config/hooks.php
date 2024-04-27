<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller'] = array( //called after controller’s constructor is called before other functions.

        'class'    => 'Changeprofilepicture',

        'function' => 'switchImage',

        'filename' => 'Changeprofilepicture.php',

        'filepath' => 'hooks', //If Hook is in hooks folder. application/hooks then filepath is hooks without trailing slash.

);