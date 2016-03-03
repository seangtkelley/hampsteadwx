<?php

namespace App\Listeners\Helpers;

class sessionAlert {
    // "success", "info", "warning", "danger"
    public $id;
    public $type;
    public $body;
    // how important the alert is 0 - 9
    public $priority;
    // will alert be deleted on first load
    // or will user have to close it
    public $stubborn;

    function __construct($id, $type, $body, $priority, $stubborn)
    {
        $this->id = $id;
        $this->type = $type;
        $this->body = $body;
        $this->priority = $priority;
        $this->stubborn = $stubborn;
    }
}
