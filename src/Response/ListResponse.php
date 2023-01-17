<?php

namespace App\Response;

class ListResponse
{
    public function __construct(
        private readonly array $items,
    )
    {
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return count($this->items);
    }
}
