<?php

namespace Storyfaktor\Mail;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class LiquidMailService
{
  /**
   * Send message with given data using specified mailer.
   *
   * @param string $template Name of the mail template
   * @param array  $data     Data to merge into the template; includes all the properties from the abstracted mailable, e.g. <i>to</i>, <i>to_name</i>, etc. and additional data as required
   * @param string $mailer   Name of {@see \Illuminate\Contracts\Mail\Mailer} to use; for available mailers see config/mail.php key 'mailers'
   * @return bool|string     <code>true</code> if sending completed without error; the error message otherwise
   */
  public function send( string $template, array $data, string $mailer )
  {

  }

  /**
   * Send message to recipients in collection with given data using specified mailer.
   *
   * @param Collection $recipients Collection should at least contain <i>email</i> addresses of the recipients; can include further user related properties
   * @param string     $template Name of the mail template
   * @param array      $data     Data to merge into the template; should include <i>from</i>, <i>from_name</i>; should not include any recipient data at all
   * @param string     $mailer   Name of {@see \Illuminate\Contracts\Mail\Mailer} to use; for available mailers see config/mail.php key 'mailers'
   * @return array
   */
  public function bulk( Collection $recipients, string $template, array $data, string $mailer )
  {

  }
}
