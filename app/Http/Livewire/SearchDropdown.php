<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';
    public $results;
    public $resource;
    public $field;
    public $event;
    public $show = false;

    public function updated($prop) {
        $this->show = true;
        if($prop == 'search') {
            $this->handleSearch();
        }
    }

    public function handleSearch() {
        $cName = "App\\" . $this->resource;
        $this->results = $cName::where('name','like','%' . $this->search . '%')
            ->get();
    }

    public function setVar($val) {
        $this->emitUp($this->event,$val);
        $field = $this->field;
        $this->search = $this->results->find($val)->$field;
        $this->show = false;
    }

    public function render()
    {
        $this->handleSearch();
        return view('livewire.search-dropdown');
    }
}
