<?php

namespace App\Controller;

use App\Entity\WebContact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebContactController extends AbstractController
{
    #[Route('/api/web_contacts', name: 'api_web_contacts_post', methods: ['POST'])]
    public function __invoke(Request $request, EntityManagerInterface $em): Response
    {
        $data = new WebContact();
        // Récupération et attribution des autres champs
        $data->setIsAn($request->request->getInt('isAn'));
        $data->setLstName($request->request->get('lstName'));
        $data->setFstName($request->request->get('fstName'));
        $data->setEmail($request->request->get('email'));
        $data->setSituation($request->request->getInt('situation'));
        $data->setNeeds($request->request->get('needs'));
        $data->setKnowSz($request->request->getInt('knowSz'));

        // Gestion du fichier
        if ($request->files->get('cvFile')) {
            $data->setCvFile($request->files->get('cvFile'));
        }

        $em->persist($data);
        $em->flush();

        return $this->json(['status' => 'Contact created'], Response::HTTP_CREATED);
    }
}
?>