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
     * The credential storage instance.
     *
     * @var CredentialStorageInterface
     */
    private $storage;

    /**
     * The key reference within the credential storage.
     *
     * @var string
     */
    private $key;

    /**
     * Constructs a new CredentialStorageReference instance.
     *
     * @param CredentialStorageInterface $storage
     * @param string                     $key
     */
    public function __construct(CredentialStorageInterface $storage, $key)
    {
        $this->storage = $storage;
        $this->key = $key;
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
