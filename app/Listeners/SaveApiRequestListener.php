<?php

namespace App\Listeners;

use App\Events\ApiRequestEvent;
use App\Http\Middleware\ApiRequests;
use App\Models\ApiRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveApiRequestListener
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
    public function handle(ApiRequestEvent $event): void
    {
        $apiRequest = new ApiRequest();
        $apiRequest->create($event->data);
    }
}
