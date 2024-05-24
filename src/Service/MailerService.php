<?php 


namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService {

    public function __construct(private readonly MailerInterface $mailer) {}

    public function send (
        string $to,
        string $subject,
        string $TemplateTwig,
        array $context) :void {

            $email = (new TemplatedEmail())
            ->from(new Address('noreply@trartzup.com', 'start-zup.com'))
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->htmlTemplate("mails/$TemplateTwig")
            ->context($context);

            try {
                $this->mailer->send($email);

            }catch(TransportException $transportExcepetion) {
                throw $transportExcepetion;
            }

        }

}

?>