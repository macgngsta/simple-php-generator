<?php

namespace App\View\Components\Button;

use ProtoneMedia\LaravelFormComponents\Components\Component;
use ProtoneMedia\LaravelFormComponents\Components\HandlesBoundValues;

class SubmitOutline extends Component
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
                $this->cssClass = 'border-gray-300 text-gray-700 hover:bg-gray-100 focus:ring-gray-500';
                break;
            case 'red':
                $this->cssClass = 'border-red-300 text-red-700 hover:bg-red-100 focus:ring-red-500';
                break;
            case 'yellow':
                $this->cssClass = 'border-yellow-300 text-yellow-700 hover:bg-yellow-100 focus:ring-yellow-500';
                break;
            case 'green':
                $this->cssClass = 'border-green-300 text-green-700 hover:bg-green-100 focus:ring-green-500';
                break;
            case 'blue':
                $this->cssClass = 'border-blue-300 text-blue-700 hover:bg-blue-100 focus:ring-blue-500';
                break;
            case 'indigo':
                $this->cssClass = 'border-indigo-300 text-indigo-700 hover:bg-indigo-100 focus:ring-indigo-500';
                break;
            case 'purple':
                $this->cssClass = 'border-purple-300 text-purple-700 hover:bg-purple-100 focus:ring-purple-500';
                break;
            case 'pink':
                $this->cssClass = 'border-pink-300 text-pink-700 hover:bg-pink-100 focus:ring-pink-500';
                break;
            default:
            $this->cssClass = 'border-gray-300 text-gray-700 hover:bg-gray-100 focus:ring-gray-500';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.button.submit-outline');
    }
}
