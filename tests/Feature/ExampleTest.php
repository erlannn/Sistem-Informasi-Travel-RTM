<?php

test('the application returns a login redirect response for unauthenticated visitors', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
});
