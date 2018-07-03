<?php

namespace AppBundle\Repository;
use AppBundle\Form\SearchParameters;
use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository
{
	public function findByParameters(SearchParameters $searchParameters)
    {
        $dql = 'SELECT a FROM AppBundle:User AS a';
        $where = [];
        $parameters = [];
        if (!empty($searchParameters->name)) {
            $where[] = ' a.name = :name ';
            $parameters['name'] = $searchParameters->name;            
        }
        if (!empty($searchParameters->grad)) {            
            $where[] = ' a.grad = :grad ';
            $parameters['grad'] = $searchParameters->grad;
        }
        if (!empty($searchParameters->obrazovanje)) {
            $where[] = 'a.obrazovanje = :obrazovanje';
            $parameters['obrazovanje'] = $searchParameters->obrazovanje;           
        }
        if (!empty($searchParameters->smijer)) {
            $where[] = 'a.smijer = :smijer';
            $parameters['smijer'] = $searchParameters->smijer;           
        }
        if (true) {
            $where[] = 'a.role = :role';
            $parameters['role'] = 'ROLE_STUDENT';           
        }
        
        if ($where) {
            $dql .= " WHERE " . implode(' AND ', $where) . " ";
        }       
        
        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameters($parameters)
            ->getResult();
    }
	
}
