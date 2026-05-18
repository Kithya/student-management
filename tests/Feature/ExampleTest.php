<?php

test('the home page renders the login screen', function () {
    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('Log in to your account');
});
