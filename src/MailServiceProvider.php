<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
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
      'mail.manager'
    ];
  }
}
