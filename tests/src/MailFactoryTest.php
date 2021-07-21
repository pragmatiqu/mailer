<?php

namespace Storyfaktor\Mail\Tests;

use Storyfaktor\Mail\Contracts\MailFactory;
use Symfony\Bridge\Twig\Mime\BodyRenderer;

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