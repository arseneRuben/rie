<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EmissionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmissionRepository extends EntityRepository
{
      public function findAll()
    {
        return $this->findBy(array(), array('nom' => 'ASC'));
    }
}
