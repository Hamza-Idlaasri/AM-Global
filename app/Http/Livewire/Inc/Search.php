<?php

namespace App\Http\Livewire\Inc;

use Livewire\Component;

class Search extends Component
{
    public $route;
    public $list;

    public function mount($route,$list)
    {
        $this->route = $route;
        $this->list = $list;
    }

    public function render()
    {
        return view('livewire.inc.search')->with(['route'=> $this->route,'list' => $this->list]);
    }
}
