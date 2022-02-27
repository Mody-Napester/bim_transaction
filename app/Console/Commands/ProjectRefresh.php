<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install The Project (Migrations and seeders)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('migrate:refresh');
        echo "All Migrated" . "\n";
        Artisan::call('db:seed');
        echo "All Seeded" . "\n";
    }
}
