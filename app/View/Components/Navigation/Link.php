<?php

namespace App\View\Components\Navigation;

use Illuminate\Http\Request;
use Illuminate\View\Component;

class Link extends Component
{
    public $title;
    public $link;
    public $isActive;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request, $title, $link)
    {
        $this->title = $title;
        $this->link = $link;
        $this->isActive = false;

        $this->init($request);
    }

    private function init(Request $request){
        $fullPath = $request->path();
        $exploded = explode('/', $fullPath);
        if($this->link == $exploded[0]){
            $this->isActive=true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.navigation.link');
    }
}
