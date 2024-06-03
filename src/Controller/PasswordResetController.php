<?php
// src/Controller/PasswordResetController.php
namespace App\Controller;

use App\Form\PasswordResetRequestFormType;
use App\Form\ChangePasswordFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordResetController extends AbstractController
{
    #[Route('/reset-password', name: 'app_forgot_password_request')]
    public function request(Request $request, UserRepository $userRepository, MailerInterface $mailer, UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(PasswordResetRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            $user = $userRepository->findOneBy(['email' => $email]);
            if (!$user) {
                throw new UserNotFoundException('Aucun utilisateur trouvé avec cet email');
            }

            $resetToken = Uuid::v4()->toRfc4122();
            $user->setResetToken($resetToken);
            $userRepository->save($user);

            $resetUrl = $urlGenerator->generate('app_reset_password', ['token' => $resetToken], UrlGeneratorInterface::ABSOLUTE_URL);

            $email = (new Email())
                ->from('support@start-zup.org')
                ->to($user->getEmail())
                ->subject('Demande de réinitialisation du mot de passe')
                ->html("Veuillez cliquer sur ce lien pour réinitialiser votre mot de passe: <a href=\"$resetUrl\">$resetUrl</a>");

            $mailer->send($email);

            $this->addFlash('success', 'Un lien vient de vous être envoyé, verifiez votre boite mail.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('resetPwd/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function reset(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, string $token): Response
    {
        $user = $userRepository->findOneBy(['resetToken' => $token]);
        if (!$user) {
            throw $this->createNotFoundException('Invalid token');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newHashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $userRepository->upgradePassword($user, $newHashedPassword);

            $user->setResetToken(null);
            $userRepository->save($user);

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('resetPwd/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
?>