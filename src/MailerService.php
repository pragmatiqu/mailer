<?php


namespace Pragmatic\Mail;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;

class MailerService implements Contracts\Mailer
{
  private TransportInterface $transport;
  private array $from;

  public function __construct( TransportInterface $transport, array $from )
  {
    $this->transport = $transport;
    $this->from = $from;
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

      // Ist kein Absender gesetzt verwenden wir die global hinterlegt
      // Absenderadresse
      if ( 0 === sizeof( $email->getFrom() ) && null !== $this->from )
      {
        $email->from( new Address( $this->from['address'], $this->from['name'] ) );
      }

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
  public function spread( Collection $recipients, string $template, array $data = [] ): array
  {
    // TODO: Implement spread() method.
  }
}