<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\Facades\Facade;

class MailFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'mail.manager';
  }
}
