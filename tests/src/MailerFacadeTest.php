<?php

namespace Storyfaktor\Mail\Tests;

use Storyfaktor\Mail\Mailer;

class MailerFacadeTest extends TestCase
{
  /** @test */
  public function can_resolve_service()
  {
    $this->assertTrue( Mailer::transport() instanceof \Storyfaktor\Mail\Contracts\Mailer );
  }
}