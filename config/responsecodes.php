<?php

return [
    // Default response
    '' => 'INVALID_RESPONSE_CODE',

    // Auth responses
    'invalid_credentials' => 'The given username / password is wrong.',

    // Token responses
    'could_not_create_token' => 'Internal error, could not create a token.',
    'token_generated' => 'Token successfully generated.',
    'token_refreshed' => 'Token refreshed.',
    'token_expired' => 'Token expired.',
    'token_invalid' => 'Invalid token.',

    // User Responses
    'user_not_found' => 'User not found.',

    'getusers_success' => 'Successfully returned users.',
    'getusers_no_content' => 'No users to return.',

    'getuser_success' =>'Successfully returned user.',
    'getuser_notfound' => 'User not found.',

    'createuser_error' => 'User was not created.',
    'createuser_success' => 'User created.',

    'deleteuser_success' => 'The user has been deleted.',
    'deleteuser_error' => 'Error deleting user.',
];
