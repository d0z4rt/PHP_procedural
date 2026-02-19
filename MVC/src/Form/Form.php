<?php
namespace App\Form;

use App\Security\Csrf\CsrfTokenTrait;

class Form implements FormInterface
{
    use CsrfTokenTrait;

    private array $fields;
    private array $data = [];
    private bool $valid = true;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function handle(array $data): void
    {
        foreach ($this->fields as $name => $config) {
            $value = $data[$name] ?? null;
            $this->data[$name] = $value;

            if (($config['options']['required'] ?? false) && empty($value)) {
                $this->valid = false;
            }
        }
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function render(): string
    {
        $html = '<form method="POST">';


        foreach ($this->fields as $name => $config) {
            $type = $config['type'];

            $html .= sprintf(
                '<input type="%s" name="%s">',
                htmlspecialchars($type),
                htmlspecialchars($name)
            );
        }
            // Ajoute le champ CSRF correctement
        $html .= sprintf(
            '<input type="hidden" name="_token" value="%s">',
            $this->generateCsrfToken('_token')
        );


        $html .= '<button type="submit">Envoyer</button></form>';

        return $html;
    }
}
