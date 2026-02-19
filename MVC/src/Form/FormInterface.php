<?php

namespace App\Form;

interface FormInterface
{
    public function render(): string;

    public function handle(array $data): void;

    public function isValid(): bool;

    public function getData(): array;
}
