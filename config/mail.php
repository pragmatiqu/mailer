<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Default Mailer
  |--------------------------------------------------------------------------
  |
  | This option controls the default mailer that is used to send any email
  | messages sent by your application. Alternative mailers may be setup
  | and used as needed; however, this mailer will be used by default.
  |
  */
  'default'   => env( 'MAIL_MAILER', 'smtp' ),

  /*
  |--------------------------------------------------------------------------
  | Mailer Configurations
  |--------------------------------------------------------------------------
  |
  | Here you may configure all of the mailers used by your application plus
  | their respective settings. Several examples have been configured for
  | you and you are free to add your own as your application requires.
  |
  | Laravel supports a variety of mail "transport" drivers to be used while
  | sending an e-mail. You will specify which one you are using for your
  | mailers below. You are free to add additional mailers as required.
  |
  | Supported: "smtp"
  |
  */
  'mailers'   => [
    'smtp' => [
      'transport'  => 'smtp',
      'host'       => env( 'MAIL_HOST', 'smtp.mailtrap.io' ),
      'port'       => env( 'MAIL_PORT', 2525 ),
      'encryption' => env( 'MAIL_ENCRYPTION', 'tls' ),
      'username'   => env( 'MAIL_USERNAME' ),
      'password'   => env( 'MAIL_PASSWORD' ),
      'timeout'    => null,
      'auth_mode'  => null,
    ],
  ],

  /*
  |--------------------------------------------------------------------------
  | Global "From" Address
  |--------------------------------------------------------------------------
  |
  | You may wish for all e-mails sent by your application to be sent from
  | the same address. Here, you may specify a name and address that is
  | used globally for all e-mails that are sent by your application.
  |
  */
  'from'      => [
    'address' => env( 'MAIL_FROM_ADDRESS', 'office@survival.at' ),
    'name'    => env( 'MAIL_FROM_NAME', 'Survival.at®' ),
  ],

  /*
   |--------------------------------------------------------------------------
   | Template engine configuration
   |--------------------------------------------------------------------------
   |
   */
  'templates' => [

    //'root' => resource_path( 'mails' ),
    'root' => '/Users/indi/git/mail/tests/fixture/mails',

    'extension'   => 'twig',

    // Accepts all Twig environment configuration options
    // @see https://twig.symfony.com/doc/3.x/api.html
    //
    'environment' => [

      // When set to true, the generated templates have a __toString() method
      // that you can use to display the generated nodes.
      // default: false
      'debug'            => env( 'APP_DEBUG', false ),

      // The charset used by the templates.
      // default: utf-8
      'charset'          => 'utf-8',

      // An absolute path where to store the compiled templates, or false to
      // disable caching. If null then the cache file path is used.
      // default: cache file storage path
      'cache'            => storage_path( 'mails/cache' ),

      // When developing with Twig, it's useful to recompile the template
      // whenever the source code changes. If you don't provide a value
      // for the auto_reload option, it will be determined automatically
      // based on the debug value.
      'auto_reload'      => true,

      // If set to false, Twig will silently ignore invalid variables
      // (variables and or attributes/methods that do not exist) and
      // replace them with a null value. When set to true, Twig throws an
      // exception instead.
      // default: false
      'strict_variables' => true,

      // If set to true, auto-escaping will be enabled by default for
      // all templates.
      // default: 'html'
      'autoescape'       => 'html',

      // A flag that indicates which optimizations to apply
      // (default to -1 -- all optimizations are enabled; set it to 0 to
      // disable)
      'optimizations'    => -1,
    ],
  ]
];