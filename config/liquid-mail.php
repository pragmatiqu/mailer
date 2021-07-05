<?php

return [

  /*
   |--------------------------------------------------------------------------
   | Deklariere alle verwendeten API Elemente
   |--------------------------------------------------------------------------
   |
   */
  'imports' => [

    'users' => [
      'model'      => config(
        'auth.providers.users.model',
        Storyfaktor\Mail\Tests\Fixture\Models\User::class
      ),
      'properties' => [
        'id'       => 'ForeignKey',
        // liste alle verwendeten Properties am User Model auf
        // …
      ]
    ]
  ]
];