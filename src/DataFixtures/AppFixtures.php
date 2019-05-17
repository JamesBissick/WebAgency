<?php

namespace App\DataFixtures;

use App\Entity\Advertising;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture {

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {

        $faker = Factory::create('en-GB');

        // Generating fake users accounts
        $users = [];
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++){

            $user = new User();

            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';
            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntro($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                ->setHash($hash)
                ->setPicture($picture);


            $manager->persist($user);
            $users[] = $user;
        }

        // Generating fake adverts
        for ($i = 0; $i<30; $i++){
            $ad = new Advertising();

            $user = $users[mt_rand(0, count($users) - 1)];

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(1);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
//            $price = $faker->randomNumber(3);

            $ad ->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(25, 150))
                ->setRooms(mt_rand(1, 6))
                ->setAuthor($user);

            for ($j = 1; $j <= mt_rand(2, 5); $j++){
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAdvert($ad);

                $manager->persist($image);
            }

            // $product = new Product();

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
