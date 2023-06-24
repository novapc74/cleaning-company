<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

abstract class BaseFixture extends Fixture
{
    private ObjectManager $manager;

    abstract protected function loadData(ObjectManager $manager);

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadData($manager);
    }

    protected function createEntity(string $className, int $count, callable $factory): void
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            $class = explode('\\', $className);
            $this->addReference(end($class) . '_' . $i, $entity);
        }
    }
}
