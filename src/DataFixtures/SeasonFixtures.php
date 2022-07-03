<?php

namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    private CONST BREAKINGBAD = [
            1 => [
                2008,
                'The first saison of Breaking Bad',
                'https://m.media-amazon.com/images/M/MV5BODFhZjAwNjEtZDFjNi00ZTEyLThkNzUtMjZmOWM2YjQwODFmXkEyXkFqcGdeQXVyMjQwMDg0Ng@@._V1_.jpg',
            ],
            2 => [
                2009,
                'The first saison of Breaking Bad',
                'https://m.media-amazon.com/images/M/MV5BODFhZjAwNjEtZDFjNi00ZTEyLThkNzUtMjZmOWM2YjQwODFmXkEyXkFqcGdeQXVyMjQwMDg0Ng@@._V1_.jpg',
            ],
            3 => [
                2010,
                'The first saison of Breaking Bad',
                'https://m.media-amazon.com/images/M/MV5BODFhZjAwNjEtZDFjNi00ZTEyLThkNzUtMjZmOWM2YjQwODFmXkEyXkFqcGdeQXVyMjQwMDg0Ng@@._V1_.jpg',
            ],
            4 => [
                2011,
                'The first saison of Breaking Bad',
                'https://m.media-amazon.com/images/M/MV5BODFhZjAwNjEtZDFjNi00ZTEyLThkNzUtMjZmOWM2YjQwODFmXkEyXkFqcGdeQXVyMjQwMDg0Ng@@._V1_.jpg',
            ],
            5 => [
                2012,
                'The first saison of Breaking Bad',
                'https://m.media-amazon.com/images/M/MV5BODFhZjAwNjEtZDFjNi00ZTEyLThkNzUtMjZmOWM2YjQwODFmXkEyXkFqcGdeQXVyMjQwMDg0Ng@@._V1_.jpg',
            ]
        ];


    /**
     * @Multiple input fixtures
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::BREAKINGBAD as $number => $value) {

                $season = new Season();
                $season->setYears($value[0]);
                $season->setNumber($number);
                $season->setDescription($value[1]);
                $season->setImage($value[2]);
                $season->setProgram($this->getReference('program_BreakingBad'));
                $manager->persist($season);
                $this->addReference('season_' . $number, $season);
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