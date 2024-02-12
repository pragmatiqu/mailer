<?php

namespace Pragmatiqu\Mail\Tests;


use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Pragmatiqu\Mail\MailerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
  }

  // @from https://github.com/orchestral/testbench/issues/211
  protected function getEnvironmentSetUp( $app )
  {
    // make sure, our .env file is loaded
    $app->useEnvironmentPath( __DIR__ . '/../..' );
    $app->bootstrapWith( [ LoadEnvironmentVariables::class ] );
    parent::getEnvironmentSetUp( $app );
  }

  public function tearDown(): void
  {
    parent::tearDown();
  }

  protected function getPackageProviders( $app )
  {
    return [
      MailerServiceProvider::class
    ];
  }
}
