<?php

use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthentication
{

    private Google2FA $g2fa;

    public function __construct()
    {
        $this->g2fa = new Google2FA();
    }

    /**
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     */
    public function generateSecretKey(){
        return $this->g2fa->generateSecretKey();
    }

}

$_2fa = new TwoFactorAuthentication();
echo $_2fa->generateSecretKey();