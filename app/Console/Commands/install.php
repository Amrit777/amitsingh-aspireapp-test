<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installation of test. Amit Singh Aspire Mini App test.';

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
        try {
            DB::connection();
        } catch (Exception $e) {
            $this->error('Unable to connect to database.');
            $this->error('Please fill valid database credentials into .env and rerun this command.');
            return;
        }

        $this->comment('Attempting to install Software - 1.0.0');

        if (!env('APP_KEY')) {
            $this->info('Generating app key');
            Artisan::call('key:generate');
        } else {
            $this->comment('App key exists -- skipping...');
        }

        $this->info('Migrating database...');

        Artisan::call('migrate', ['--force' => true]);

        $this->comment('Database Migrated Successfully...');

        $this->info('Seeding DB data...');

        Artisan::call('db:seed', ['--force' => true]);

        $this->comment('Database Seeded Successfully...');

        $this->info('Installing passport keys....');

        Artisan::call('passport:install', ['--force' => true]);

        $this->comment('Passport keys installed Successfully...');

        $this->comment('Successfully Installed! You can now run the software');

    }
}
