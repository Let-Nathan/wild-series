<?php

namespace App\DataFixtures;


use App\Entity\Episode;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @WITH fixtures
     */
    private CONST EPISODES_BREAKINGBAD = [
            0 => [
                'Episode',
                1,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img2.acsta.net/pictures/18/07/23/11/26/1237965.jpg',
                1
            ],
            1 => [
                'Episode',
                2,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img2.acsta.net/pictures/18/07/23/11/26/1237965.jpg',
                1
            ],
            2 => [
                'Episode',
                3,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img2.acsta.net/pictures/18/07/23/11/26/1237965.jpg',
                1
            ],
            3 => [
                'Episode',
                4,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img2.acsta.net/pictures/18/07/23/11/26/1237965.jpg',
                1
            ],
            4 => [
                'Episode',
                5,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img2.acsta.net/pictures/18/07/23/11/26/1237965.jpg',
                1
            ],
            5 => [
                'Episode',
                1,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img6.acsta.net/pictures/18/07/23/11/26/1597342.jpg',
                2
            ],
            6 => [
                'Episode',
                3,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img6.acsta.net/pictures/18/07/23/11/26/1597342.jpg',
                2
            ],
            7 => [
                'Episode',
                4,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img6.acsta.net/pictures/18/07/23/11/26/1597342.jpg',
                2
            ],
            8 => [
                'Episode',
                5,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img6.acsta.net/pictures/18/07/23/11/26/1597342.jpg',
                2
            ],
            9 => [
                'Episode',
                6,
                'Walter White a 50 ans. Professeur de chimie dans un lycée, il travaille également dans une entreprise de lavage de voitures ...',
                'https://fr.web.img6.acsta.net/pictures/18/07/23/11/26/1597342.jpg',
                2
            ]
        ];
    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES_BREAKINGBAD as $season => $value) {
                $episode= new Episode();
                $episode->setTitle($value[0]);
                $episode->setNumber($value[1]);
                $episode->setSynopsis($value[2]);
                $episode->setImages($value[3]);
                $episode->setSeason($this->getReference('season_' . $value[4]));
                $manager->persist($episode);
            }

        $manager->flush();
    }
    /**
     * @WITH faker
     */



//    public function load(ObjectManager $manager)
//    {
//        $faker = Factory::create();
//            for($i = 0; $i < 50; $i++) {
//                $episode= new Episode();
//                $episode->setTitle($faker->words(1, true) );
//                $episode->setNumber($faker->numberBetween(0, 50) );
//                $episode->setSynopsis($faker->text(60) );
//                $episode->setImages($faker->imageUrl(640, 480, 'animals', true) );
//                $episode->setSeason($this->getReference('season_' . $faker->numberBetween(1, 5)) );
//                $manager->persist($episode);
//            }
//        $manager->flush();
//    }



    public function getDependencies(): array
    {
        return [
            SeasonFixtures::class,
        ];
    }
}