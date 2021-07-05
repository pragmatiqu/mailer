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
  }
}
