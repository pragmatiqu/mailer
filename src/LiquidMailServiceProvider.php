<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\ServiceProvider;

class LiquidMailServiceProvider extends ServiceProvider
{
  public function boot()
  {
    if ( $this->app->runningInConsole() )
    {
      $this->publishes( [
        __DIR__ . '/../config/liquid-mail.php' => config_path( 'liquid-mail.php' ),
      ], 'config' );

    }
  }

  public function register()
  {
    $this->mergeConfigFrom( __DIR__ . '/../config/liquid-mail.php', 'liquid-mail' );
  }
}
