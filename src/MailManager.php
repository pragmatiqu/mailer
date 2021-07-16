<?php

namespace Storyfaktor\Mail;

use Illuminate\Contracts\Mail\Factory as FactoryContract;
use InvalidArgumentException;

class MailManager implements FactoryContract
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

  public function mailer( $name = null )
  {
    $name = $name ?: $this->app['config']['mail.default'];

    return $this->mailers[$name] = $this->get( $name );
  }

  /**
   * Attempt to get the mailer from the local cache.
   *
   * @param string $name
   * @return \Illuminate\Mail\Mailer
   */
  protected function get( $name )
  {
    return $this->mailers[$name] ?? $this->resolve( $name );
  }

  /**
   * Resolve the given mailer.
   *
   * @param string $name
   * @return \Illuminate\Mail\Mailer
   *
   * @throws \InvalidArgumentException
   */
  protected function resolve( $name )
  {
    $config = $this->app['config']["mail.mailers.{$name}"];

    if ( is_null( $config ) )
    {
      throw new InvalidArgumentException( "Mailer [{$name}] is not defined." );
    }

    /** {@see \Illuminate\Mail\MailManager} */
  }
}