<?php

namespace Pragmatic\Mail;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @method static \Pragmatic\Mail\Contracts\Mailer transport( string $name = null )
 * @method static bool|string send( TemplatedEmail $email, array $data )
 * @method static array spread( Collection $recipients, TemplatedEmail $email, array $data )
 *
 * @see \Pragmatic\Mail\Contracts\Mailer
 * @see \Pragmatic\Mail\MailerManager
 */
class Mailer extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'mailer.manager';
  }
}
