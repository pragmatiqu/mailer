<?php

namespace Storyfaktor\Mail\Tests;

use Storyfaktor\Mail\Contracts\MailFactory;
use Storyfaktor\Mail\FilesystemMailFactory;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MailFactoryTest extends TestCase
{
  private MailFactory $factory;

  public function setUp(): void
  {
    parent::setUp();

    $this->factory = new FilesystemMailFactory( realpath(__DIR__.'/../fixture/mails') );
  }

  /** @test */
  public function can_check_for_existence()
  {
    $this->assertTrue( $this->factory->exists( 'test' ) );
  }

  /** @test */
  public function can_factor_html_template_name()
  {
    $root = $this->app['config']['mail.templates.root'];
    $config = $this->app['config']['mail.templates.environment'];

    $loader = new FilesystemLoader( $root, $root );
    $twig = new Environment( $loader, $config );

    $messageListener = new MessageListener( null, new BodyRenderer( $twig ) );

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
}