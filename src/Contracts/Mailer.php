<?php

namespace Pragmatic\Mail\Contracts;

use Illuminate\Support\Collection;
use Pragmatic\Mail\Status;
use Pragmatic\Mail\TemplatedEmail;

interface Mailer
{
  /**
   * Send message with given data.
   *
   * @param TemplatedEmail $email Name of the mail template
   * @param array          $data  Additional data to merge into the template
   * @return Status     The status of the send
   */
  public function send( TemplatedEmail $email, array $data = [] ): Status;

  /**
   * Send message to recipients in collection with given data.
   * Use this method to send bulk mails.
   *
   * @param Collection $recipients Collection should at least contain <i>email</i> addresses of the recipients; can include further user related properties
   * @param string     $template   Name of the mail template
   * @param array      $data       Additional data to merge into the template
   * @return Status[] for any given record in the recipients collection
   */
  public function spread( Collection $recipients, string $template, array $data = [] ): array;

  // TODO Die Collection werden wir auch noch minimal spezifizieren und dann geht’s dahin…
}
