<?php

namespace Accompli\CredentialStorage;

/**
 * CredentialStorageReference.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class CredentialStorageReference
{
    /**
     * The key reference within the credential storage.
     *
     * @var string
     */
    private $key;

    /**
     * The credential storage instance.
     *
     * @var CredentialStorageInterface
     */
    private $storage;

    /**
     * Constructs a new CredentialStorageReference instance.
     *
     * @param string                     $key
     * @param CredentialStorageInterface $storage
     */
    public function __construct($key, CredentialStorageInterface $storage)
    {
        $this->key = $key;
        $this->storage = $storage;
    }

    /**
     * Returns the decrypted value from the credentials storage.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->storage->decrypt($this->key);
    }
}
