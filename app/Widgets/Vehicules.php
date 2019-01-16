<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Vehicules extends AbstractWidget
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
        $count = \App\Vehicule::count();
        $string = 'Vehicule dans la base de donée';//trans_choice('voyager::dimmer.user', $count);
        

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-truck',
            'title'  => "{$count} {$string}",
            'text'   => 'Vous avez '. $count .' véhicules dans la base de donée',//__('voyager::dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => 'Consulter',
                'link' => route('voyager.vehicules.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/fleet.jpg'),
        ]));
    }
}
