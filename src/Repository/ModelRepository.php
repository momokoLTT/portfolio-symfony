<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    protected function getEntityName(): string
    {
        return Model::class;
    }
}
