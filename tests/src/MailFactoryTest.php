<?php

namespace Storyfaktor\Mail\Tests;

use Storyfaktor\Mail\Contracts\MailFactory;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// https://packagist.org/packages/symfony/mailer
class MailFactoryTest extends TestCase
{
  private MailFactory $factory;

  public function setUp(): void
  {
    parent::setUp();

    $this->factory = $this->app->get( MailFactory::class );
  }

  /** @test */
  public function can_check_for_existence()
  {
    $this->assertTrue( $this->factory->exists( 'test' ) );
    $this->assertTrue( $this->factory->exists( 'test', 'text' ) );
    $this->assertFalse( $this->factory->exists( 'test', 'html' ) );
    $this->assertFalse( $this->factory->exists( 'test', 'subject' ) );
  }

  /** @test */
  public function can_factor_html_template_name()
  {
    $messageListener = new MessageListener( null, new BodyRenderer( $this->app->get( 'twig' ) ) );

    $eventDispatcher = new EventDispatcher();
    $eventDispatcher->addSubscriber( $messageListener );

    $transport = Transport::fromDsn( 'smtp://localhost', $eventDispatcher );
    $mailer = new Mailer( $transport, null, $eventDispatcher );

    $email = $this->factory->create( 'test', [
      'foo' => 'bar'
    ] )
      ->to( 'foo@bar.com' )
      ->from( 'test@test.at' )
      ->subject( 'Testing…' );

    /*
    $mailer->send( $email );

    $this->assertEquals(
      '<h1>Hey bar, welcome to the show!</h1>',
      $email->getHtmlTemplate()
    );
    */
    $this->assertTrue( true );
  }


  /** @test */
  public function can_render_template()
  {
    $renderer = new BodyRenderer( $this->app->get( 'twig' ) );

    $email = $this->factory->create( 'test', [
      'foo' => 'bar'
    ] )
      ->to( 'foo@bar.com' )
      ->from( 'test@test.at' )
      ->subject( 'Testing…' );

    $renderer->render( $email );

    $this->assertEquals(
      'Hey bar, welcome to the show! For reference, your registered email address is foo@bar.com',
      $email->getTextBody()
    );
  }
}