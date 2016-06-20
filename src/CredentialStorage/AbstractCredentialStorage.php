<?php

namespace Accompli\CredentialStorage;

/**
 * AbstractCredentialStorage.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
abstract class AbstractCredentialStorage implements CredentialStorageInterface
{
    const CIPHER = 'aes-256-gcm';

    /**
     * The encryption secret.
     *
     * @var string
     */
    private static $secret;

    /**
     * The array with keys and their encrypted values.
     *
     * @var array
     */
    protected $encryptedStorage = array();

    /**
     * {@inheritdoc}
     */
    public function setSecret($secret)
    {
        static::$secret = $secret;
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($key)
    {
        if (isset($this->encryptedStorage[$key])) {
            $initializationVectorLength = openssl_cipher_iv_length(static::CIPHER);
            $initializationVector = substr($this->encryptedStorage[$key], 0, $initializationVectorLength);

            return openssl_decrypt(substr($this->encryptedStorage[$key], $initializationVectorLength), static::CIPHER, static::$secret, 0, $initializationVector);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($key, $value)
    {
        $initializationVector = openssl_random_pseudo_bytes(openssl_cipher_iv_length(static::CIPHER));

        $this->encryptedStorage[$key] = $initializationVector.openssl_encrypt($value, static::CIPHER, static::$secret, 0, $initializationVector);
    }
}