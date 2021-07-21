<?php


namespace Storyfaktor\Mail;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
   */
  public function send( TemplatedEmail $email, array $data = [] ): Status
  {
    try
    {
      // Die Idee ist folgende: Wenn ich eine Serienmail versende, enthält
      // das Template nur die globalen Variablen (e.g. Links auf Social Media…)
      // und über die send() Methode werden dann die jeweiligen Benutzervariablen
      // übergeben. Die werden hier nun miteinander vermischt.
      $email->context( array_merge( $email->getContext(), $data ) );

      $message = $this->transport->send( $email, null );

      return ( new Status( $message->getMessageId(), $email->getTo()[0] ) )
        ->delivered();
    }
    catch ( TransportExceptionInterface $e )
    {
      Log::error( $e->getMessage(), $e->getTrace() );

      return ( new Status( null, $email->getTo()[0] ) )
        ->failed()
        ->withError( $e->getMessage() );
    }
  }

  /**
   * @inheritDoc
   */
  public function spread( Collection $recipients, TemplatedEmail $email, array $data = [] ): array
  {
    // TODO: Implement spread() method.
  }
}