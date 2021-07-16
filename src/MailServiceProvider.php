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
        __DIR__ . '/../config/mail.php' => config_path( 'mail.php' ),
      ], 'config' );
    }
  }

  public function register()
  {
    $this->mergeConfigFrom( __DIR__ . '/../config/mail.php', 'mail' );

    $this->app->singleton('mail.manager', function ($app) {
      return new MailManager($app);
    });

    $this->app->bind('mailer', function ($app) {
      return $app->make('mail.manager')->mailer();
    });

    $this->app->singleton( MailService::class, function ( $app )
    {
      return new MailService();
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
      'mail.manager',
      'mailer',
      MailService::class
    ];
  }
}
