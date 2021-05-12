<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\City;
use Exception;
use Illuminate\Support\Facades\DB;

class citiesSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cities:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncroniza las ciudades desde navision';

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
        $postalCodes = City::getNav();
        
        DB::beginTransaction();
        try {
            foreach ($postalCodes as $key => $val) {
                City::updateOrCreate([
                    'code' => $val['Code'],
                ],[
                    'code'   => $val['Code'],
                    'city'   => $val['City'],
                    'county' => $val['County'],
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollBack();
        }
        die();
    }
}
