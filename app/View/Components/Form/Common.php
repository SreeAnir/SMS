<?php

namespace App\View\Components\Form;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Common extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getId()
    {
        return $this->attributes->get('id', $this->attributes->get('name'));
    }

    public function getName()
    {
        return $this->attributes->get('name',$this->attributes->get('id'));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|string|View
     */
    public function render()
    {
        return '';
    }
}
