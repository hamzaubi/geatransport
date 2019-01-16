<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Carbon\Carbon;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Mileages extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

    	Carbon::now();
        $count = \App\Mileage::where($this->getCurrentMonth(),'=',null)->count();
        $string = 'Véhicule sans kilométrage';//trans_choice('voyager::dimmer.user', $count);


        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-dashboard',
            'title'  => "{$count} {$string}",
            'text'   => 'Vous avez '. $count .' véhicules qui nécessitent une mise a jour de kilométrage.',//__('voyager::dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => 'Consulter',
                'link' => route('voyager.mileages.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/mileage.jpg'),
        ]));
    }

    public function getCurrentMonth(){
    		 $now = Carbon::now();
    		$month = $now->format('m');
    			switch ($month) {
    				case 1:
    				return 'jan';
    				
    				case 2:
    				return 'feb';
    			
    					case 3:
    				return 'mar';
    		
    					case 4:
    				return 'apr';
    				
    					case 5:
    				return 'may';
    			
    					case 6:
    				return 'jun';
    			
    					case 7:
    				return 'jul';
    			
    					case 8:
    				return 'aug';
    			
    					case 9:
    				return 'sep';
    			
    					case 10:
    				return 'oct';
    		
    						case 11:
    				return 'nov';
    		
    						case 12:
    				return 'dec';
    	
    				default:
    					break;
    			}


    }
}
