<?php

namespace App\Listeners {

    use App\Events\Alert;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use App\Listeners\AlertListener\sessionAlert;

    class AlertListener
    {

        public $alerts = array();

        /**
         * Create the event listener.
         *
         * @return mixed
         */
        public function __construct()
        {
            $this->check_alerts();
        }

        /**
         * Handle the event.
         *
         * @param  Alert $event
         * @return void
         */
        public function handle(Alert $event)
        {
            if ($event->method == 'create') {
                $priority = (isset($event->data['priority']) ? $event->data['priority'] : 0);
                $stubborn = (isset($event->data['stubborn']) ? $event->data['stubborn'] : false);
                $this->createAlert($event->data['type'], $event->data['body'], $priority, $stubborn);
            } else if ($event->method == 'delete') {
                $this->removeAlerts($event->data['ids']);
            }
        }

        public function check_alerts()
        {
            if (!empty(session('alerts'))) {
                $this->depackageAlerts();
            }
        }

        // create alert to be displayed
        public function createAlert($type, $body, $priority = 0, $stubborn = false)
        {
            $id = count($this->alerts);
            array_push($this->alerts, new sessionAlert($id, $type, $body, $priority, $stubborn));
            //array_push($this->alerts, array('id' => $id, 'type' => $type, 'body' => $body, 'priority' => $priority, 'stubborn' => $stubborn));
            $this->packageAlerts();
        }

        // remove alert
        public function removeAlert($id)
        {
            array_splice($this->alerts, $id, 1);
            $this->updateAlertIDs();
            $this->packageAlerts();
        }

        // remove multiple alerts
        public function removeAlerts($ids)
        {
            for ($i = 0; $i < count($ids); $i++) {
                for ($j = 0; $j < count($this->alerts); $j++) {
                    if ($this->alerts[$j]->id == $ids[$i]) {
                        array_splice($this->alerts, $j, 1);
                    }
                }
            }
            $this->updateAlertIDs();
            $this->packageAlerts();
        }

        // update the ids of the alerts
        public function updateAlertIDs()
        {
            for ($x = 0; $x < count($this->alerts); $x++) {
                $this->alerts[$x]->id = $x;
            }
            $this->packageAlerts();
        }

        // return the alerts as they are stored
        public function getAlerts()
        {
            return $this->alerts;
        }

        // sort and return the alerts
        public function getAlertsSorted()
        {
            /*
                Alerts will first be clustered by type
                    Order: danger, warning, success, info

                Then sorted by priority within their clusters
            */
            // cluster alerts
            $errors = array();
            $warnings = array();
            $successes = array();
            $infos = array();
            foreach ($this->alerts as $alert) {
                if ($alert->type == "danger") {
                    array_push($errors, $alert);
                } else if ($alert->type == "warning") {
                    array_push($warnings, $alert);
                } else if ($alert->type == "success") {
                    array_push($successes, $alert);
                } else if ($alert->type == "info") {
                    array_push($infos, $alert);
                }
            }

            // order by priority
            $errors = $this->orderByPriority($errors);
            $warnings = $this->orderByPriority($warnings);
            $successes = $this->orderByPriority($successes);
            $infos = $this->orderByPriority($infos);

            // rebuild alerts array
            $sortedArrays = array_merge($errors, $warnings, $successes, $infos);
            return $sortedArrays;
        }

        private function orderByPriority($alerts)
        {
            $n = count($alerts);
            for ($c = 0; $c < ($n - 1); $c++) {
                for ($d = 0; $d < $n - $c - 1; $d++) {
                    if ($alerts[$d]->priority < $alerts[$d + 1]->priority) /* For decreasing order use < */ {
                        $swap = $alerts[$d];
                        $alerts[$d] = $alerts[$d + 1];
                        $alerts[$d + 1] = $swap;
                    }
                }
            }
            return $alerts;
        }

        public function packageAlerts(){
            $package = array();
            $sorted = $this->getAlertsSorted();
            for ($x = 0; $x < count($sorted); $x++) {
                $package[$x] = serialize($sorted[$x]);
            }
            session(['alerts' => $package]);
        }

        public function depackageAlerts(){
            $package = session('alerts');
            $alerts = array();
            for ($x = 0; $x < count($package); $x++) {
                $alerts[$x] = unserialize($package[$x]);
            }
            $this->alerts = $alerts;
        }
    }
}

namespace App\Listeners\AlertListener {
    class sessionAlert
    {
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
}