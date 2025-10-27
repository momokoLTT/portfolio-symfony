<?php

namespace App\Controller;

use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class OverviewController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/', name: 'overview')]
    public function index()
    {
        $entities = $this->em->getRepository(Model::class)->findAll();

        return $this->render('models/overview.html.twig', ['models' => $entities]);
    }
}
