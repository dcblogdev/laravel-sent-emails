<?php

//fails due to login route not existing directly in package
test('guests cannot access the sent emails page', function () {
    $this->get(route('sentemails.index'))->assertStatus(500);
});
