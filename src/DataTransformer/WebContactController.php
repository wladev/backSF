<?php

// src/Controller/WebContactController.php

namespace App\Controller;

use App\Entity\WebContact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;



// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class WebContactController extends AbstractController
{
    #[Route('/api/web_contacts', name: 'api_web_contacts_post', methods: ['POST'])]
    public function __invoke(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, MailerInterface $mailer ): Response
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

        $errors = $validator->validate($data);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($data);
        $em->flush();


        // Envoi de l'email de notification
        $email = (new Email())
            ->from('no-reply@wpersonaliser.net')
            ->to('wladimir.perfiloff.dev@gmail.com')
            ->subject('Nouvelle demande de contact')
            ->text(sprintf(
                "Une nouvelle demande de contact a été effectuée par %s %s. \n\nConnectez-vous au dashboard web pour consulter l'ensemble des informations. \n\nEmail: %s\n\nMessage:\n%s",
                $data->getFstName(),
                $data->getLstName(),
                $data->getEmail(),
                $data->getNeeds()
            ));


        $mailer->send($email);
        // $this->addFlash(
        //     'success',
        //     'Votre demande a été envoyée avec succès'
        // );

        return $this->json(['status' => 'Contact created'], Response::HTTP_CREATED);
    }
}

?>