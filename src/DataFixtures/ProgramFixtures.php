<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    private CONST PROGRAM = [
        'Action' => [
            'BreakingBad' => [
                'When you want make some money...',
                'https://m.media-amazon.com/images/M/MV5BODFhZjAwNjEtZDFjNi00ZTEyLThkNzUtMjZmOWM2YjQwODFmXkEyXkFqcGdeQXVyMjQwMDg0Ng@@._V1_.jpg',
                'USA',
                2008-01-2008,
                'user1',
                ]
        ],
        'Aventure' => [
            'JumanJi' => [
                'Jumanji test synopsis',
                'https://fr.web.img6.acsta.net/pictures/17/11/07/13/40/0517792.jpg',
                'USA',
                2008-01-2008,
                'user1',
                ]
        ],
        'Animation' => [
            'Nausicaa' => [
                'Nausicaa test synopsis',
                'https://fr.web.img3.acsta.net/medias/nmedia/18/62/56/68/18651925.jpg',
                'USA',
                2008-01-2008,
                'user2',
                ]
        ],
        'Fantastique' => [
            'Gardien de la galaxie' => [
                'Gardien de la galaxie test synopsis',
                'https://fr.web.img5.acsta.net/pictures/14/08/04/15/09/405662.jpg',
                'USA',
                2008-01-2008,
                'user2',
            ]
        ],
        'Horreur' => [
            'Silent Hill' => [
                'Silent Hill test synopsis',
                'https://fr.web.img6.acsta.net/medias/nmedia/18/93/95/83/20289333.jpg',
                'USA',
                8-01-2008,
                'user3',
                ]
        ],
    ];

    /**
     * @One input fixtures
     */

    /**
     * @Multiple input fixtures
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAM as $category => $array) {
            foreach ($array as $title => $values) {

                $program = new Program();
                $program->setTitle($title);
                $slug = $this->slugify->generate($title);
                $program->setSlug($slug);
                $program->setSynopsis($values[0]);
                $program->setImage($values[1]);
                $program->setCountry($values[2]);
                $program->setYears($values[3]);
                $program->setCategory($this->getReference('category_' . $category));
                $program->setOwner($this->getReference('user_' . $values[4]));
                $manager->persist($program);
                $this->addReference('program_' . $title, $program);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}