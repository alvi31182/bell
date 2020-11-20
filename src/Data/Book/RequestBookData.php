<?php

declare(strict_types=1);

namespace App\Data\Book;

final class RequestBookData
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}