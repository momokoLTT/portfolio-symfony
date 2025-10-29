<?php

namespace App\DataFixtures;

use App\Data\CreditType;
use App\Data\LinkType;
use App\Entity\Credit;
use App\Entity\Link;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ModelFixtures extends Fixture
{
    private Generator $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 10; ++$i) {
            $model = new Model()
                ->setId('testModel' . $i)
                ->setTitle($this->faker->jobTitle)
                ->setDescription($this->faker->paragraph(2))
                ->setImage('none.jpg')
                ->setCredits($this->generateCredits($manager));

            $manager->persist($model);
        }

        $manager->flush();
    }

    private function generateCredits(ObjectManager $manager): array
    {
        $credits = [];

        foreach (CreditType::values() as $type) {
            $amountToGenerate = random_int(1, 2);
            for ($i = 0; $i < $amountToGenerate; $i++) {
                $credit = $this->generateCredit($type);
                $manager->persist($credit);
                $credits[] = $credit;
            }
        }

        $manager->flush();

        return $credits;
    }

    private function generateCredit(string $type): Credit
    {
        $links = [];
        $linksToGenerate = random_int(1, 5);
        for ($i = 0; $i < $linksToGenerate; $i++) {
            $links[] = $this->generateLink();
        }

        $credit = new Credit()->setType($type)->setName($this->faker->firstName);
        foreach ($links as $link) {
            $credit->addLink($link);
        }

        return $credit;
    }

    private function generateLink(): Link
    {
        return new Link()
            ->setType(LinkType::values()[array_rand(LinkType::values())])
            ->setIdentifier($this->faker->userName);
    }
}
