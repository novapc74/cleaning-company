<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends BaseFixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function loadData(ObjectManager $manager): void
    {
        $admin = $manager->getRepository(User::class)->findOneBy(['email' => 'new-email@yandex.ru']);

        if (null === $admin) {
            $this->createEntity(User::class, 1, function (User $user) {
                $user
                    ->setEmail('new-email@yandex.ru')
                    ->setRoles(["ROLE_ADMIN"])
                    ->setPassword($this->passwordEncoder->hashPassword($user, 'super-password'));
            });

            $manager->flush();
        }
    }
}

