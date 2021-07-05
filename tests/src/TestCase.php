<?php

namespace Storyfaktor\Mail\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Storyfaktor\Mail\MailServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
  }

  public function tearDown(): void
  {
    parent::tearDown();
  }

  protected function getPackageProviders( $app )
  {
    return [
      MailServiceProvider::class
    ];
  }
}
