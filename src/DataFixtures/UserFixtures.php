<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\User;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $pwd;

    public function __construct(UserPasswordHasherInterface $pwd) {

        $this->pwd = $pwd;
    }

    CONST USER = [
        'user1' => [
            'admin@gmail.com',
            'ROLE_ADMIN',
            'azerty',
        ],

        'user2' => [
            'user@gmail.com',
            'ROLE_USER',
            'azerty',
        ],

        'user3' => [
            'contributor@gmail.com',
            'ROLE_CONTRIBUTOR',
            'azerty',
        ]

    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::USER as $name => $value) {

                $user = new User();
                $user->setEmail($value[0]);
                $user->setRoles( [$value[1]] );
                $user->setPassword($this->pwd->hashPassword($user, $value[2]));
                $user->setFirstName($name);
                $this->addReference('user_' . $name, $user);
                $manager->persist($user);

            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}