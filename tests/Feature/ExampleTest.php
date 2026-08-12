<?php

use function Pest\Laravel\get;

test('the application returns a successful response for unauthenticated visitors', function () {
    $response = get('/');

    $response->assertStatus(200);
});
