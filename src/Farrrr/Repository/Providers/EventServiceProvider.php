<?php
namespace Farrrr\Repository\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application
     *
     * @var array
     */
    protected $listen = [
        'Farrrr\Repository\Events\RepositoryEntityCreated' => [
            'Farrrr\Repository\Listeners\CleanCacheRepository'
        ],
        'Farrrr\Repository\Events\RepositoryEntityUpdated' => [
            'Farrrr\Repository\Listeners\CleanCacheRepository'
        ],
        'Farrrr\Repository\Events\RepositoryEntityDeleted' => [
            'Farrrr\Repository\Listeners\CleanCacheRepository'
        ],
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        $events = app('events');

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}