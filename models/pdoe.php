<?php
/* models/pdoe.php
 *
 */

defined('_EXE') or die('Acceso restringido');

class PDOe extends PDO
{
    protected $prx;

    protected $demo;

    public function __construct($db, $user, $pwd, $options=null, $prefix=null)
    {
        $this->prx = $prefix? $prefix : 'pri_';

        $this->demo = $prefix? true : false;

        parent::__construct($db, $user, $pwd, $options);
    }

    public function getPrx()
    {
        return $this->prx;
    }

    public function isDemo()
    {
        return $this->demo? true : false;
    }
}
