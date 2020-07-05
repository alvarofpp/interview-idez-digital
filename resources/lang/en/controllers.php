<?php

/*
|--------------------------------------------------------------------------
| Structure
|--------------------------------------------------------------------------
|
| class (like UserController, etc)
|   '- method (like index, store, update, destroy, etc)
|        '- return_success
|        '- return_error
|        '- return_custom01
|        '- return_custom02
*/

return [
    'AuthController' => [
        'login' => [
            'error' => 'Incorrect credentials.',
        ],
        'logout' => [
            'success' => 'Come back often!',
            'error' => 'There is no open session.',
        ],
    ],
    'RegisterController' => [
        'register' => [
            'success' => 'User registered successfully!',
            'error' => 'An error occurred during user registration.',
        ],
    ],
];
