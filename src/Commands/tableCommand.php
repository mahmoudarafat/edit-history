<?php

namespace MahmoudArafat\EditHistory\Commands;

use Illuminate\Console\Command;
use MahmoudArafat\EditHistory\Traits\DatabaseConfig as TraitsDatabaseConfig;

class tableCommand extends Command
{
    use TraitsDatabaseConfig;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edithistory:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create edit_histories table';

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
     * @return mixed
     */
    public function handle()
    {

        $this->configEditHistoryTable();

    }
}