<?php

namespace App\Listeners;

use App\Events\NovoPremioCadstrado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\CadastroPremio;

class EnviarEmailNovoPremio
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NovoPremioCadstrado $event): void
    {
        Mail::to($event->user->email)->send(new NovoPremioCadastrado($event->user, $event->premio));
    }
}
