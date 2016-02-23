<?php

namespace  CodeProject\Events;

use CodeProject\Entities\ProjectTasks;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskWasInclude extends Event implements ShouldBroadcast{

    //utilizando esse metodo o laravel pega todas as variaveis publicas e serealiza
    use SerializesModels;

    public $task;

    public function __construct(ProjectTasks $tasks){
        $this->task = $tasks;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    /*
     * Canal que cia com o serviço de real time
     */
    public function broadcastOn(){
        return ['user.'.\Authorizer::getResourceOwnerId()];
    }
}