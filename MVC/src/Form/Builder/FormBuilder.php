<?php

namespace App\Form\Builder;

use App\Form\Form;
use App\Form\FormInterface;

class FormBuilder implements FormBuilderInterface
{
    private array $fields = [];

    public function add(string $name, string $type, array $options = []): self
    {
        $this->fields[$name] = [
            'type' => $type,
            'options' => $options
        ];

        return $this;
    }

    public function getForm(): FormInterface
    {
        return new Form($this->fields);
    }
}
