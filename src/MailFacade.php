<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\Facades\Facade;

/**
 * @see \StoryFaktor\Community\Community
 */
class MailFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'mail';
  }
}
