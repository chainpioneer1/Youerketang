<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/28/2017
 * Time: 9:15 AM
 */

class MY_Session extends CI_Session {
    public function __construct($params = array())
    {
        parent::CI_Session($params);
    }

    public function sess_update()
    {
        if ( IS_AJAX )
        {
            parent::sess_update();
        }
    }
}