<?php

namespace App\Console\Commands;

use App\Mileage;
use Illuminate\Console\Command;

class CalculateMileage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Calculate:Mileage';
    public $totalmileage;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Special Command to calculate fleet mileage';

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
        $mileages = Mileage::all();
       foreach ($mileages as $mileage) {
          echo ("working with vehicule :".$mileage->vehicule->matricule."\n");
            $vmm =($mileage->oct - $mileage->sep);
            if ($vmm <= 0) {
                 $vmm = (($mileage->oct - $mileage->sep)+($mileage->sep - $mileage->aug)+($mileage->aug - $mileage->jul)+($mileage->jul - $mileage->jun)+($mileage->jun - $mileage->may)+($mileage->may - $mileage->apr)+($mileage->apr - $mileage->mar)+($mileage->mar - $mileage->feb)+($mileage->feb - $mileage->jan))/10;
                    echo ("vehicule mm ->".$vmm."\n");
                    $this->totalmileage +=$vmm; 
            }elseif($vmm >= 7000){
          // $vmm = (($mileage->oct - $mileage->sep)+($mileage->sep - $mileage->aug)+($mileage->aug - $mileage->jul)+($mileage->jul - $mileage->jun)+($mileage->jun - $mileage->may)+($mileage->may - $mileage->apr)+($mileage->apr - $mileage->mar)+($mileage->mar - $mileage->feb)+($mileage->feb - $mileage->jan))/10;
          echo ("vehicule mm ->".$vmm."\n");
             // $this->totalmileage +=$vmm; 
            }else{

            echo ("vehicule mm ->".$vmm."\n");
            $this->totalmileage +=$vmm; 
            }
      
       }
       echo "$this->totalmileage";
    }

}
