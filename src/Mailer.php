<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @method static void macro( string $name, object|callable $macro )
 * @method static bool|string send( TemplatedEmail $email, array $data )
 * @method static array spread( Collection $recipients, TemplatedEmail $email, array $data )
 *
 * @see \Storyfaktor\Mail\Contracts\MailService
 * @see \Storyfaktor\Mail\MailerManager
 */
class Mailer extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'mail.manager';
  }
}
