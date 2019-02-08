<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr-FR");
              
        //Créer le role Admin
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        //Créer un user qui aura le role admin
        $adminUser = new User();
        $adminUser->setFirstname('Olivier')
                    ->setLastName('Clercq')
                    ->setEmail('admin@admin.fr')
                    ->setHash($this->encoder->encodePassword($adminUser , 'password'))
                    ->setPicture('../img/photo_profil.png')
                    ->setIntroduction($faker->sentence())
                    ->setDescription('Administrateur du site')
                    ->addUserRole($adminRole);
        $manager->persist($adminUser);

        //gestion des utilisateurs
         $users = [];
         $genres = ['male' , 'female'];

        for($i = 1; $i <= 20; $i++){
            $user = new User();
            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99). '.jpg';
            
            $hash = $this->encoder->encodePassword($user , 'password');

            if($genre == 'male'){
                $picture = $picture . 'men/' . $pictureId;
            }else {
                $picture = $picture . 'women/' . $pictureId;
            }

            $user->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastname)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>' , $faker->paragraphs(3)) . '</p>')
                ->setHash($hash)
                ->setPicture($picture);

                $manager->persist($user);
                $users[] = $user;
        }

        //gestion des annonces
        for($i = 1; $i < 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>' , $faker->paragraphs(5)) . '</p>';

            $user = $users[mt_rand(0 , count($users) -1 )];
           

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(99 , 250))
                ->setRooms(mt_rand(2 , 4))
                ->setAuthor($user);
            for($j = 1; $j <= mt_rand(2,5); $j++) {
                $image = new Image();
                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                    $manager->persist($image);
            }         

                $manager->persist($ad);
        }

        //Gestion des réservations
        for($j = 1; $j <= mt_rand(0,10); $j++){
            $booking = new Booking();

            $createdAd = $faker->dateTimeBetween(' -6 month ');
            $startDate = $faker->dateTimeBetween(' -3 month ');
            $duration = mt_rand(3,8);
            $endDate = (clone $startDate)->modify("+$duration days");
            $amount = $ad->getPrice() * $duration;
            $booker = $users[mt_rand(0 , count($users) -1)];
            $comment = $faker->paragraph();

            $booking->setBooker($booker)
                    ->setAd($ad)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setCreatedAd($createdAd)
                    ->setAmount($amount)
                    ->setComment($comment);

            $manager->persist($booking);
        }

        $manager->flush();
    }
}
