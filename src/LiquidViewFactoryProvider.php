<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;

class LiquidViewFactoryProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->singleton( LiquidViewFactory::class, function ( $app )
    {
      $finder = new FileViewFinder( $app['files'], $app['config']['view.mails'], [ 'css', 'html', 'md', 'txt' ] );
      return new LiquidViewFactory( $finder );
    } );
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }


  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [ LiquidViewFactory::class ];
  }
}
