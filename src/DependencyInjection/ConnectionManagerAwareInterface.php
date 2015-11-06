<?php

namespace Accompli\DependencyInjection;

use Accompli\Deployment\Connection\ConnectionManagerInterface;

/**
 * ConnectionManagerAwareInterface.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
interface ConnectionManagerAwareInterface
{
    /**
     * Sets the connection manager.
     *
     * @param ConnectionManagerInterface $connectionManager
     */
    public function setConnectionManager(ConnectionManagerInterface $connectionManager);
}
