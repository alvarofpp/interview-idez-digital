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
    'UserController' => [
        'update' => [
            'success' => 'User updated successfully!',
            'error' => 'An error occurred during the user update.',
        ],
        'destroy' => [
            'success' => 'User successfully deleted!',
            'error' => 'An error occurred during user removal.',
        ],
    ],
    'AccountController' => [
        'store' => [
            'success' => 'Account created successfully!',
            'error' => 'An error occurred while registering a new account.',
        ],
        'update' => [
            'success' => 'Account updated successfully!',
            'error' => 'An error occurred while updating the account.',
        ],
        'destroy' => [
            'success' => 'Account successfully deleted!',
            'error' => 'An error occurred while removing the account.',
        ],
    ],
    'TransactionController' => [
        'store' => [
            'success' => 'Transaction successfully registered!',
            'error' => 'An error occurred while registering a new transaction.',
        ],
    ],
];
