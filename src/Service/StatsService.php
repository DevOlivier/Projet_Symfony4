<?php

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;



class StatsService
{
    private $manager;

    public function __construct(ObjectManager $manager){
        $this->manager = $manager;
    }

    public function getStats(){
        $users = $this->getUsersCount();
        $ads = $this->getAdsCount();
        $bookings = $this->getBookingsCount();
        $comments = $this->getCommentsCount();

        return compact('users' , 'ads' , 'bookings' , 'comments');
    }

    public function getUsersCount(){
        return $this->manager->createQuery('SELECT count(u) FROM APP\Entity\User u')->getSingleScalarResult();
    }

    public function getAdsCount(){
        return $this->manager->createQuery('SELECT count(a) FROM APP\Entity\Ad a')->getSingleScalarResult();
    }

    public function getBookingscount(){
        return $this->manager->createQuery('SELECT count(b) FROM APP\Entity\Booking b')->getSingleScalarResult();
    }

    public function getCommentsCount(){
        return $this->manager->createQuery('SELECT count(c) FROM APP\Entity\Comment c')->getSingleScalarResult();
    }
}
