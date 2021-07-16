<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;

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

    $this->app->singleton( LiquidViewFactory::class, function ( $app )
    {
      // TODO Wo die Templates gespeichert sind, sollte im eigenen Config File stehen!
      // TODO Templates haben die Extension .liquid (FileViewFinder entsprechend konfigurieren)
      $finder = new FileViewFinder( $app['files'], $app['config']['view.mails'], [ 'css', 'html', 'md', 'txt' ] );
      // TODO Globale Daten, wie die aus config/ci.php, etc. über share() hinzufügen
      return new LiquidViewFactory( $finder );
    } );

    $this->app->singleton( LiquidMailService::class, function ( $app )
    {
      return new LiquidMailService();
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
      LiquidViewFactory::class,
      LiquidMailService::class
    ];
  }
}
