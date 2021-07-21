<?php


namespace Storyfaktor\Mail;


use Illuminate\Support\Collection;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Transport\TransportInterface;

class MailerService implements Contracts\Mailer
{

  private TransportInterface $transport;

  public function __construct( TransportInterface $transport )
  {
    $this->transport = $transport;
  }

  /**
   * @inheritDoc
   * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
   */
  public function send( TemplatedEmail $email, array $data = [] ): array
  {
    $this->transport->send( $email, null );

    return [];
  }

  /**
   * @inheritDoc
   */
  public function spread( Collection $recipients, TemplatedEmail $email, array $data = [] ): array
  {
    // TODO: Implement spread() method.
  }
}