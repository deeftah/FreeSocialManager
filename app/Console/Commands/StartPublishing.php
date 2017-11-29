<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\FSM\PublishController;

class StartPublishing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fsm:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start publishing your social media content';

    protected $publishController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PublishController $publishController)
    {
        parent::__construct();
        $this->publishController = $publishController;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->publishController->index();
    }
}
