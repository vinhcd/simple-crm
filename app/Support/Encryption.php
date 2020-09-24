<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use ParagonIE\Halite\Asymmetric\Crypto;
use ParagonIE\Halite\HiddenString;
use ParagonIE\Halite\KeyFactory;

class Encryption
{
    /**
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    private $fileSystem;

    /**
     * Encryption constructor.
     */
    public function __construct()
    {
        $this->fileSystem = Storage::disk('secure');
    }

    /**
     * @param string $value
     * @return string
     * @throws \ParagonIE\Halite\Alerts\CannotPerformOperation
     * @throws \ParagonIE\Halite\Alerts\InvalidKey
     * @throws \ParagonIE\Halite\Alerts\InvalidType
     */
    public function encrypt($value)
    {
        $publicKey = KeyFactory::loadEncryptionPublicKey($this->fileSystem->path('key_public'));

        return Crypto::seal(new HiddenString($value), $publicKey);
    }

    /**
     * @todo: might use upload method for secret key to increase its security
     * @param string $encryptedValue
     * @return string
     * @throws \ParagonIE\Halite\Alerts\CannotPerformOperation
     * @throws \ParagonIE\Halite\Alerts\InvalidKey
     * @throws \ParagonIE\Halite\Alerts\InvalidMessage
     * @throws \ParagonIE\Halite\Alerts\InvalidType
     */
    public function decrypt($encryptedValue)
    {
        $secretKey = KeyFactory::loadEncryptionSecretKey($this->fileSystem->path('key_secret'));

        return Crypto::unseal($encryptedValue, $secretKey)->getString();
    }
}
