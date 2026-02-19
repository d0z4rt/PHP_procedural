<?php
namespace App\Form\Builder;

use App\Form\FormInterface;

interface FormBuilderInterface
{
    public function add(string $name, string $type, array $options = []): self;

    public function getForm(): FormInterface;
}
