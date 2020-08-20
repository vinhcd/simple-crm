<?php

namespace App\Models\Traits;

trait AccessorMutatorGenerator
{
    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (!method_exists($this, $method)) {
            $property = $this->revertMethod($method);
            if (str_starts_with($method, 'get')) {
                if (in_array($property, $this->properties)) {
                    return $this->$property;
                }
            } elseif (str_starts_with($method, 'set')) {
                if (in_array($property, $this->properties)) {
                    $parameters[0] = isset($parameters[0]) ? $parameters[0] : '';
                    $this->$property = $parameters[0];
                    return $this;
                }
            }
        }
        return parent::__call($method, $parameters);
    }

    /**
     * @param $method
     * @return string|string[]|null
     */
    private function revertMethod($method)
    {
        return preg_replace('/^(get_|set_)/', '', preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $method), 1);
    }
}
