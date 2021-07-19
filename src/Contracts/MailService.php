<?php

namespace Storyfaktor\Mail\Contracts;

use Illuminate\Support\Collection;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

interface MailService
{
  /**
   * Send message with given data using specified mailer. Use this method for
   * single mails with <i>Cc</i> and <i>Bcc</i> recipients.
   *
   * @param TemplatedEmail $email Name of the mail template
   * @param array          $data  Additional data to merge into the template
   * @return array     The {@see \Storyfaktor\Mail\Contracts\MailStatus}es for any given {@see \Symfony\Component\Mime\Address} on the $email
   */
  public function send( TemplatedEmail $email, array $data = [] ): array;

  /**
   * Send message to recipients in collection with given data using specified mailer.
   * Use this method to send bulk mails. <i>Cc</i> and <i>Bcc</i> headers will be ignored!
   *
   * @param Collection     $recipients Collection should at least contain <i>email</i> addresses of the recipients; can include further user related properties
   * @param TemplatedEmail $email      Name of the mail template
   * @param array          $data       Additional data to merge into the template
   * @return array The {@see \Storyfaktor\Mail\Contracts\MailStatus}es for any given {@see \Symfony\Component\Mime\Address} in the $recipients collection; <i>Cc</i> and <i>Bcc</i> on $email will be ignored
   */
  public function spread( Collection $recipients, TemplatedEmail $email, array $data = [] ): array;

  // TODO Die Collection werden wir auch noch minimal spezifizieren und dann geht’s dahin…
}
