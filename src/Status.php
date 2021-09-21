<?php


namespace Pragmatic\Mail;


use Symfony\Component\Mime\Address;

class Status
{

  /**
   * @var string the transport messageId
   */
  private string $messageId;

  /**
   * @var Address the e-mail address this status applies to
   */
  private Address $address;

  /**
   * @var bool|null the delivery status of the mail
   */
  private ?bool $delivered;

  /**
   * @var string|null any error that occurred during handling
   */
  private ?string $error;

  public function __construct( string $messageId, Address $address )
  {
    $this->messageId = $messageId;
    $this->address = $address;
  }

  public function getMessageId(): string
  {
    return $this->messageId;
  }

  public function getAddress(): Address
  {
    return $this->address;
  }

  public function isDelivered(): bool
  {
    return $this->delivered;
  }

  public function delivered(): Status
  {
    $this->delivered = true;

    return $this;
  }

  public function failed(): Status
  {
    $this->delivered = false;

    return $this;
  }

  public function getError(): string
  {
    return $this->error;
  }

  public function withError( string $error ): Status
  {
    $this->error = $error;

    return $this;
  }
}