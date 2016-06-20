<?php

namespace Accompli\CredentialStorage;

/**
 * CredentialStorageInterface.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
interface CredentialStorageInterface
{
    /**
     * Loads the stored credentials without decrypting them.
     */
    public function load();

    /**
     * Sets the encryption secret.
     *
     * @param string $secret
     */
    public function setSecret($secret);

    /**
     * Returns the decrypted value referenced by key from the credential storage.
     *
     * @param string $key
     *
     * @return string
     */
    public function decrypt($key);

    /**
     * Encrypts and stores the value in the credential storage referenced by key.
     *
     * @param string $key
     * @param string $value
     */
    public function encrypt($key, $value);
}
