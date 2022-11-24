<?php

namespace App\Http\Traits;

use Ripcord\Ripcord as RipcordRipcord;
use Ripcord\Client\Client as Client;

trait OdooIntegrationTrait
{
    private int $user_id;
    private Client $models;
    private string $odoo_db;
    private string $odoo_password;

    private function connect(){
        $db = config("odoo_configuration")['db'];
        $username = config("odoo_configuration")['username'];
        $password = config("odoo_configuration")['password'];
        $url = config("odoo_configuration")['url'];

//        $common = RipcordRipcord::client("$url/xmlrpc/2/common");
//        // get user id
//        $uid = $common->authenticate($db, $username, $password, array());
//        // select model
//        $models = RipcordRipcord::client("$url/xmlrpc/2/object");

//        $this->user_id = $uid;
//        $this->models = $models;
        $this->odoo_db = $db;
        $this->odoo_password = $password;
    }

    public function sendDataToOdoo($modelKeys, $enable){
//        if($enable){
//            $this->connect();
//            $this->models->execute_kw($this->odoo_db, $this->user_id, $this->odoo_password, 'res.partner', 'create', array(array($modelKeys)));
//        }
    }
}
