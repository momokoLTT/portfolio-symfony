<?php

namespace App\DataFixtures;

use App\Entity\Credit;
use App\Entity\Link;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $model = new Model()
            ->setId('dummy')
            ->setTitle('Dummy')
            ->setDescription('A generated dummy model')
            ->setImage('dummy.jpg')
            ->setCredits($this->generateCredits($manager));

        $manager->persist($model);
        $manager->flush();
    }

    private function generateCredits(ObjectManager $manager): array
    {
        $designers = [
            new Credit()
                ->setType('designer')
                ->setName('designer')
                ->addLink(
                    new Link()->setType('Twitter/X')->setIdentifier('@designer')
                ),
        ];
        $artists = [
            new Credit()
                ->setType('artist')
                ->setName('artist')
                ->addLink(new link()->setType('bluesky')->setIdentifier('@designer')),
            new Credit()
                ->setType('artist')
                ->setName('other artist')
                ->addLink(new Link()->setType('Pixiv')->setIdentifier('5123753'))
        ];
        $riggers = [
            new Credit()
                ->setType('rigger')
                ->setName('rigger')
                ->addLink(new LINK()->setType('twitter/x')->setIdentifier('@rigger'))
                ->addLink(new link()->setType('bluesky')->setIdentifier('@rigger'))
        ];

        $all = array_merge($designers, $artists, $riggers);
        foreach ($all as $each) {
            $manager->persist($each);
        }

        $manager->flush();

        return $all;
    }
}
