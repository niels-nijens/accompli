<?php

namespace Accompli\Test\CredentialStorage;

/**
 * AbstractCredentialStorageTest.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class AbstractCredentialStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $credentialStorage = $this->getMockBuilder(\Accompli\CredentialStorage\AbstractCredentialStorage::class)
                ->setConstructorArgs(array('/project/working/directory'))
                ->getMockForAbstractClass();

        $this->assertAttributeSame('/project/working/directory', 'workingDirectory', $credentialStorage);
    }

    public function testSetSecret()
    {
        $credentialStorage = $this->getMockBuilder(\Accompli\CredentialStorage\AbstractCredentialStorage::class)
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();

        $credentialStorage->setSecret('s3cReT');

        $this->assertAttributeSame('s3cReT', 'secret', $credentialStorage);
    }
}
