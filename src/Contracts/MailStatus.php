<?php


namespace Storyfaktor\Mail\Contracts;


use Symfony\Component\Mime\Address;
use Throwable;

interface MailStatus
{

  public function getMessageId();

  public function getAddress(): Address;

  public function isDelivered(): bool;

  public function getError(): Throwable;
}