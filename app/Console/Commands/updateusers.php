<?php

namespace App\Console\Commands;

use App\Vehicule;
use Illuminate\Console\Command;

class updateusers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $Mileages = \App\Mileage::all();

        foreach ($Mileages as $key => $mileage) {
             $vehicule = \App\Vehicule::find($mileage->id);
             $vehicule->user_id = $mileage->fullname;
             echo ($vehicule->matricule." -------> ".$vehicule->user_id."\n");
             //$this->ask('Do you want to udapte the table');
             $vehicule->save();

        }
    }
}
