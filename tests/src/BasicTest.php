<?php

namespace Storyfaktor\Mail\Tests;

use Illuminate\Support\Str;
use Storyfaktor\Mail\Status;
use Symfony\Component\Mime\Address;

class BasicTest extends TestCase
{
  /** @test */
  public function status_is_delivered()
  {
    $email = 'foo@bar.com';
    $address = new Address( $email );
    $messageId = Str::random( 10 );

    $status = ( new Status( $messageId, $address ) )
      ->delivered();
    $this->assertEquals( $messageId, $status->getMessageId() );
    $this->assertTrue( $status->isDelivered() );
    $this->assertEquals( $email, $address->getEncodedAddress() );
  }
}