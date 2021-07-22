<?php

namespace Storyfaktor\Mail\Tests;

use Storyfaktor\Mail\Contracts\MailFactory;
use Storyfaktor\Mail\Mailer;

class MailerFacadeTest extends TestCase
{
  /** @test */
  public function can_resolve_service()
  {
    $this->assertTrue( Mailer::transport() instanceof \Storyfaktor\Mail\Contracts\Mailer );
  }

  /** @test */
  public function can_send_mail()
  {
    if ( is_null( env( 'MAIL_USER' ) ) )
    {
      // We don’t want this test to be run on github…
      $this->assertTrue( true );
      return;
    }

    $user = env( 'MAIL_USER' );
    $pass = env( 'MAIL_PASS' );
    $this->app['config']['mailer.transports.mailtrap'] = "smtp://{$user}:{$pass}@smtp.mailtrap.io:2525";

    $email = $this->app->get( MailFactory::class )
      ->create( 'test', [
        'foo' => 'bar'
      ] )
      ->to( 'foo@bar.com' )
      ->from( 'test@test.at' )
      ->subject( 'Testing…' );

    $status = Mailer::transport( 'mailtrap' )->send( $email );
    $this->assertTrue( $status->isDelivered() );
  }
}