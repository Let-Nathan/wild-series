<?php

namespace App\DataFixtures;


use App\Entity\Actor;
use App\Entity\actors;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorsFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $progRef = ['BreakingBad', 'JumanJi', 'Nausicaa', 'Gardien de la galaxie', 'Silent Hill'];

        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $actors = new Actor();
            $actors->setFirstname($faker->firstName());
            $actors->setLastname($faker->lastName());
            $actors->setBirthDate($faker->dateTimeThisCentury('+10 years'));
            $actors->addProgram($this->getReference('program_' . $progRef[(rand(0,4))]) );
            $manager->persist($actors);
        }
        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}