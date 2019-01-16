<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Incidents extends AbstractWidget
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
       $count = \App\user::count();
        $string = 'Accidents Repportés ce mois';//trans_choice('voyager::dimmer.user', $count);
        
        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-tools',
            'title'  => "{$count} {$string}",
            'text'   => 'Vous avez '. $count .' accidents reporté',//__('voyager::dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => 'Consulter',
                'link' => route('voyager.users.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/car_crash.jpg'),
        ]));
    }
}
