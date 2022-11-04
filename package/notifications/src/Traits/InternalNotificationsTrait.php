<?php

namespace Gtech\AbnayiyNotification\Traits;


trait InternalNotificationsTrait
{

    public $notification;

    public function __construct() {
        parent::__construct();
    }

    public function sendInternalNotification($notification)
    {
        // $this->notification = $notification;
       return parent::$contents;
    }
}
