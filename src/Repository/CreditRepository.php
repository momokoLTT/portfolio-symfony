<?php

namespace App\Repository;

use App\Entity\Credit;
use Doctrine\ORM\EntityRepository;

class CreditRepository extends EntityRepository
{
    protected function getEntityName(): string
    {
        return Credit::class;
    }
}
