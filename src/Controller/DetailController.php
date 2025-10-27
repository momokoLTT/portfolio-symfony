<?php

namespace App\Controller;

use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class DetailController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/{slug}', name: 'detail')]
    public function index()
    {
        $entity = $this->em->getRepository(Model::class)->findOneBy(['id' => $this->getParameter('slug')]);
        if (!$entity instanceof Model) {
            return $this->redirectToRoute('overview');
        }

        return $this->render('models/detail.html.twig', ['model' => $entity]);
    }
}
