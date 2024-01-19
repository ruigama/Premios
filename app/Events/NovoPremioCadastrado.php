<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\CadastroPremio;

class NovoPremioCadastrado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $premio;

    public function __construct(User $user, CadastroPremio $premio)
    {
        $this->user = $user;
        $this->premio = $premio;
    }

    public function build()
    {
        return $this->view('novo_premio_cadastrado');
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
