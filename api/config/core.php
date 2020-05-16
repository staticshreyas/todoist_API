<?php
// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Asia/Kolkata');

// variables used for jwt
$key = "example_key";
$iss = "http://example.org"; //issuer identifies the principal that issued the JWT.
$aud = "http://example.com"; //audience claim identifies the recipients that the JWT is intended for.
$iat = 1356999524; // The iat (issued at) claim identifies the time at which the JWT was issued.
$nbf = 1357000000; //claim identifies the time before which the JWT MUST NOT be accepted for processing.
?>