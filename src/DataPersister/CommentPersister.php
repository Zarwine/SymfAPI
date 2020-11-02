<?php

namespace App\DataPersister;

use App\Entity\Comment;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;

class CommentPersister implements DataPersisterInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data): bool
    {
        return $data instanceof Comment;        
    }

    public function persist($data)
    {
        $data->setCreatedAt(new \DateTime());
        $this->em->persist($data);
        $this->em->flush($data);
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush($data);
    }    
}