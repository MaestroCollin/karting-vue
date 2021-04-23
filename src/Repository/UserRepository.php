<?php
// src/App/Repository/UserRepository.php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function getDeelnemers($activiteitid)
    {
        $em = $this->getEntityManager();


        $query = $em->createQuery("SELECT d FROM App:User d WHERE :activiteitid MEMBER OF d.activiteiten");

        $query->setParameter('activiteitid', $activiteitid);

        return $query->getResult();
    }

    public function findByRole($role)
    {
     
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"' . $role . '"%');
        return $qb->getQuery()->getResult();
    }
}
