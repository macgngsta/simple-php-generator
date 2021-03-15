<?php

namespace App\View\Components\Button;

use ProtoneMedia\LaravelFormComponents\Components\Component;
use ProtoneMedia\LaravelFormComponents\Components\HandlesBoundValues;

class Submit extends Component
{
    use HandlesBoundValues;

    public $function;
    public $color;
    public $cssClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($function, $color)
    {
        $this->function = $function;
        $this->color = $color;

        switch($color){
            case 'gray':
                $this->cssClass = 'text-white bg-gray-600 hover:bg-gray-700 focus:ring-gray-500';
                break;
            case 'red':
                $this->cssClass = 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500';
                break;
            case 'yellow':
                $this->cssClass = 'text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500';
                break;
            case 'green':
                $this->cssClass = 'text-white bg-green-600 hover:bg-green-700 focus:ring-green-500';
                break;
            case 'blue':
                $this->cssClass = 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500';
                break;
            case 'indigo':
                $this->cssClass = 'text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500';
                break;
            case 'purple':
                $this->cssClass = 'text-white bg-purple-600 hover:bg-purple-700 focus:ring-purple-500';
                break;
            case 'pink':
                $this->cssClass = 'text-white bg-pink-600 hover:bg-pink-700 focus:ring-pink-500';
                break;
            default:
                $this->cssClass = 'text-white bg-gray-600 hover:bg-gray-700 focus:ring-gray-500';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button.submit');
    }
}
