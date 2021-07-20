<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\ServiceProvider;
use Storyfaktor\Mail\Contracts\MailFactory;

class MailServiceProvider extends ServiceProvider
{
  public function boot()
  {
    if ( $this->app->runningInConsole() )
    {
      $this->publishes( [
        __DIR__ . '/../config/mail.php' => config_path( 'mail.php' ),
      ], 'config' );
    }
  }

  public function register()
  {
    $this->mergeConfigFrom( __DIR__ . '/../config/mail.php', 'mail' );

    $this->app->singleton( MailFactory::class, function ( $app )
    {
      return new FilesystemMailFactory( $app['config']['mail.templates.root'] );
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
      'mailer.manager'
    ];
  }
}
