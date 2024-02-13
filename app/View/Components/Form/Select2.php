<?php

namespace App\View\Components\Form;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Select2 extends Common
{
    /**
     * Create a new component instance.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function __construct(
        public $label,
        public $options = null,
        public $sourceUrl = null,
        public $value = null,
        public $valueKey = 'id',
        public $dataKey = 'id',
        public $textKey = 'name',
    ) {
        if ($sourceUrl === null && $options === null) {
            throw new BindingResolutionException('Either options or source_url attributes are required for select2 component!');
        }
        parent::__construct();
    }

    public function getOptions()
    {
        return collect($this->sourceUrl ? $this->getPreSelect() : $this->options)->map(function ($option) {
            $option_value = $this->getValue($option);
            $data_key = $this->getDataKey($option);
            return [
                'value' => $option_value,
                'data_key' => $data_key,
                'text' => $this->getText($option),
                'selected' => $this->sourceUrl || $this->isSelected($option_value),
            ];
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.form.select2');
    }

    private function get($option, $key)
    { 
        return match (true) {
            is_object($option) => $option->{$key} ?? $key.'-not found!',
            is_array($option) => $option[$key] ?? $key.'-not found!',
            default => $option,
        };
    }

    private function getPreSelect()
    {
        return !is_iterable($this->value) ? Arr::wrap($this->value) : $this->value;
    }

    private function getValue($option)
    {
        return $this->get($option, $this->valueKey);
    }
    private function getDataKey($option)
    { 
        return $this->get($option, $this->dataKey);
    }
    private function getText($option)
    {
        return $this->get($option, $this->textKey);
    }

    private function isSelected($option_value)
    {
        if ($this->value instanceof Collection) {
            return $this->value->contains($this->valueKey, '=', $option_value);
        }

        if (is_array($this->value)) {
            return in_array((string) $option_value, $this->value);
        }

        if (is_object($this->value)) {
            return (string) $this->value->{$this->valueKey} === (string) $option_value;
        }

        return (string) $this->value === (string) $option_value;
    }
}
