<?php

namespace App\Repository;

use App\Entity\Link;
use Doctrine\ORM\EntityRepository;

class LinkRepository extends EntityRepository
{
    protected function getEntityName(): string
    {
        return Link::class;
    }
}
