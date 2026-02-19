<?php

Namespace App\Class;


class GestionReservation
{
    private int $capacity;
    private int $reserved = 0;

    public function __construct(int $capacity)
    {
        if ($capacity <= 0) {
            throw new \InvalidArgumentException("Capacité invalide.");
        }

        $this->capacity = $capacity;
    }

    public function reserve(int $places): void
    {
        if ($places <= 0) {
            throw new \InvalidArgumentException("Nombre de places invalide.");
        }

        if ($this->reserved + $places > $this->capacity) {
            throw new \RuntimeException("Pas assez de places disponibles.");
        }

        $this->reserved += $places;
    }

    public function cancel(int $places): void
    {
        if ($places <= 0) {
            throw new \InvalidArgumentException("Nombre invalide.");
        }

        if ($places > $this->reserved) {
            throw new \RuntimeException("Impossible d'annuler plus que réservé.");
        }

        $this->reserved -= $places;
    }

    public function getAvailablePlaces(): int
    {
        return $this->capacity - $this->reserved;
    }
}
