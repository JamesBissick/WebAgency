<?php

namespace App\DataFixtures;

use App\Entity\Advertising;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture {

    public function load(ObjectManager $manager) {

        $faker = Factory::create('en-GB');

        for ($i = 0; $i<30; $i++){
            $ad = new Advertising();

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
                ->setRooms(mt_rand(1, 6));

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
