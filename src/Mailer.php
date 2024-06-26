<?php

namespace Pragmatiqu\Mail;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Pragmatiqu\Mail\Contracts\Mailer transport( string $name = null )
 * @method static bool|string send( TemplatedEmail $email, array $data )
 * @method static array spread( Collection $recipients, TemplatedEmail $email, array $data )
 *
 * @see \Pragmatiqu\Mail\Contracts\Mailer
 * @see \Pragmatiqu\Mail\MailerManager
 */
class Mailer extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'mailer.manager';
  }
}
