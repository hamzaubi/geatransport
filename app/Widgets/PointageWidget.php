<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class PointageWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    public $pointage; 
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
   

        return view('widgets.pointage_widget', [
            'config' => $this->config,
        ]);
    }
}
