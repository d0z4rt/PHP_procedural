<?php
namespace App\Controllers;

use App\Form\FormInterface;
use App\Form\Builder\FormBuilder;
use App\Form\Builder\FormBuilderInterface;

abstract class AbstractController implements FormBuilderInterface
{


    public function __construct(protected ?FormBuilderInterface $formBuilder = null)
    {
        $this->formBuilder = $formBuilder ?? new FormBuilder();
    }

    public function add(string $name, string $type, array $options = []): self
    {
        $this->formBuilder->add($name, $type, $options);
        return $this;
    }

    public function getForm(): FormInterface
    {
        return $this->formBuilder->getForm();
    }
}
