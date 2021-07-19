<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\Traits\Macroable;
use InvalidArgumentException;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MailerManager
{
  use Macroable;

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
   * The twig environment.
   *
   * @var Environment
   */
  protected $twig;

  /**
   * Create a new MailService instance.
   *
   * @param \Illuminate\Contracts\Foundation\Application $app
   * @return void
   */
  public function __construct( $app )
  {
    $this->app = $app;

    $root = $this->app['config']['mail.templates.root'];
    $config = $this->app['config']['mail.templates.environment'];

    $loader = new FilesystemLoader( $root, $root );
    $this->twig = new Environment( $loader, $config );
  }

  /**
   * @param string|null $name
   * @return MailerInterface
   */
  public function name( $name = null ): MailerInterface
  {
    $name = $name ?: $this->app['config']['mail.default'];

    return $this->mailers[$name] = $this->get( $name );
  }

  /**
   * Attempt to get the mailer from the local cache.
   *
   * @param string $name
   * @return MailerInterface
   */
  protected function get( $name ): MailerInterface
  {
    return $this->mailers[$name] ?? $this->resolve( $name );
  }

  /**
   * Resolve the given mailer.
   *
   * @param string $name
   * @return MailerInterface
   *
   * @throws \InvalidArgumentException
   */
  protected function resolve( $name ): MailerInterface
  {
    $config = $this->app['config']["mail.mailers.{$name}"];

    if ( is_null( $config ) )
    {
      throw new InvalidArgumentException( "Mailer [{$name}] is not defined." );
    }

    /** {@see \Illuminate\Mail\MailManager} */

  }

}