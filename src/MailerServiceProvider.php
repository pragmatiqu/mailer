<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\ServiceProvider;
use Storyfaktor\Mail\Contracts\MailFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MailerServiceProvider extends ServiceProvider
{
  public function boot()
  {
    if ( $this->app->runningInConsole() )
    {
      $this->publishes( [
        __DIR__ . '/../config/mailer.php' => config_path( 'mailer.php' ),
      ], 'config' );
    }
  }

  public function register()
  {
    $this->mergeConfigFrom( __DIR__ . '/../config/mailer.php', 'mailer' );

    $this->app->singleton( 'twig', function ( $app )
    {
      $root = $this->app->runningUnitTests()
        ? realpath( __DIR__ . '/../tests/fixture/mails' )
        : $app['config']['mailer.templates.root'];
      return new Environment( new FilesystemLoader( $root, $root ), $app['config']['mailer.templates.environment'] );
    } );

    $this->app->singleton( MailFactory::class, function ( $app )
    {
      return new FilesystemMailFactory( $this->app->runningUnitTests() ? realpath( __DIR__ . '/../tests/fixture/mails' ) : $app['config']['mailer.templates.root'] );
    } );

    $this->app->singleton( 'mailer.manager', function ( $app )
    {
      return new MailerManager( $app );
    } );
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [
      'mailer.manager',
      'twig',
      MailFactory::class
    ];
  }
}
