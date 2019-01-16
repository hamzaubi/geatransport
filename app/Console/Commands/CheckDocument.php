<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Check:Document';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check outside document and notify gea transport ';

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
            $decharges = \App\Decharge::out();
            $matricules=''; 
            foreach ($decharges as $key => $decharge) {
             $matricules =$matricules.$decharge->vehicule->matricule."    chez:   ".$decharge->user->name ."\n";          
            }
             echo($matricules);
              Mail::raw('Bonjour,'."\n"."Les documents des véhicules suivant sont toujours pas resittués:"."\n\n".$matricules."Saltutations\nTransport Websys", function($message) {
               $message->subject('Situation documents')->to('gea_transport@sonahess.local');
              }); 
    }
}
