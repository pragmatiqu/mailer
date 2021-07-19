<?php


namespace Storyfaktor\Mail\Contracts;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;

interface MailFactory
{
  /**
   * @param string $name Name of the template to look for
   * @return bool
   */
  public function exists( string $name ): bool;

  /**
   * @param string $name Name of the requested template
   * @param array  $data Additional data for the template
   * @return TemplatedEmail
   */
  public function create( string $name, array $data = [] ): TemplatedEmail;
}