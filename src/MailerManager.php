<?php

namespace Storyfaktor\Mail;

use InvalidArgumentException;
use Storyfaktor\Mail\Contracts\Mailer;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\Mailer\Transport;

class MailerManager
{
  /**
   * The application instance.
   *
   * @var \Illuminate\Contracts\Foundation\Application
   */
  protected $app;

  /**
   * The array of resolved mailers.
   *
   * @var array
   */
  protected $mailers = [];

  /**
   * Create a new MailService instance.
   *
   * @param \Illuminate\Contracts\Foundation\Application $app
   * @return void
   */
  public function __construct( $app )
  {
    $this->app = $app;
  }

  /**
   * @param string|null $name
   * @return Mailer
   */
  public function transport( string $name = null ): Mailer
  {
    $name = $name ?: $this->app['config']['mailer.default'];

    if ( !array_key_exists( $name, $this->mailers ) )
    {
      $config = $this->app['config']["mailer.transports.{$name}"];

      if ( is_null( $config ) )
      {
        throw new InvalidArgumentException( "Mailer [{$name}] is not defined." );
      }

      $listener = new MessageListener( null, new BodyRenderer( $this->app->get( 'twig' ) ) );

      $dispatcher = new EventDispatcher();
      $dispatcher->addSubscriber( $listener );

      $transport = Transport::fromDsn( $config, $dispatcher );

      $this->mailers[$name] = new MailerService( $transport );
    }

    return $this->mailers[$name];
  }

  /**
   * Dynamically call the default mailer instance.
   *
   * @param string $method
   * @param array  $parameters
   * @return mixed
   */
  public function __call( string $method, array $parameters )
  {
    return $this->transport()->$method( ...$parameters );
  }
}