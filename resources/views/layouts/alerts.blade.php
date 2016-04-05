<div id="alerts">
    @if(!empty(session('alerts')))
        @foreach (session('alerts') as $alert)
            <div class="alert alert-{{unserialize($alert)->type}} alert-dismissible" style="margin-bottom:5px;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{unserialize($alert)->body}}
            </div>
        @endforeach
    @endif

    <?php
        if(!empty(session('alerts'))){
            $ids = array();
            foreach (session('alerts') as $alert){
                array_push($ids, unserialize($alert)->id);
            }
            event(new App\Events\Alert('delete', array('ids' => $ids)));
        }
    ?>
</div>
