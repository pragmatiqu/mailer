<?php

namespace Storyfaktor\Mail\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Storyfaktor\Mail\LiquidMailServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();

    // MAILER_DSN=smtp://5c4f01ba19fbcc:1481a3a0b12556@smtp.mailtrap.io:2525
  }

  public function tearDown(): void
  {
    parent::tearDown();
  }

  protected function getPackageProviders( $app )
  {
    return [
      LiquidMailServiceProvider::class
    ];
  }
}
