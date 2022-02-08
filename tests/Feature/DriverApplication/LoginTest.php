<?php

it('redirects to steam', function () {
    $this->post(route('driver-application.auth.steam'))
        ->assertRedirect();
});
