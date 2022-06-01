<?php

declare(strict_types=1);

namespace App\Shared\Persistence;

use App\Entity\Club;

interface IClubRepository
{
    public function save(Club $club): void;

    // public function remove(Club $club): void;

    public function search(int $id): ?Club;
}
