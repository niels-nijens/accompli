<?php

namespace Accompli\Task;

use Accompli\Accompli;
use Accompli\AccompliEvents;
use Accompli\EventDispatcher\Event\FailedEvent;
use Accompli\EventDispatcher\Event\HostEvent;
use Accompli\EventDispatcher\Event\LogEvent;
use Accompli\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\Event;

/**
 * NotifierTask.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class NotifierTask implements TaskInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        return array(
            AccompliEvents::CREATE_CONNECTION => array(
                array('onCreateConnectionNotify', 10),
            ),
            /*AccompliEvents::INSTALL_RELEASE => array(
                array('onInstallReleaseNotify', 10),
            ),*/
            AccompliEvents::INSTALL_RELEASE_COMPLETE => array(
                array('onCompleteNotify', 0),
            ),
            AccompliEvents::INSTALL_RELEASE_FAILED => array(
                array('onFailedNotify', 0),
            ),
            /*AccompliEvents::PREPARE_DEPLOY_RELEASE => array(
                array('onPrepareDeployReleaseNotify', 10),
            ),*/
            AccompliEvents::DEPLOY_RELEASE_COMPLETE => array(
                array('onCompleteNotify', 0),
            ),
            AccompliEvents::ROLLBACK_RELEASE_COMPLETE => array(
                array('onCompleteNotify', 0),
            ),
            AccompliEvents::DEPLOY_RELEASE_FAILED => array(
                array('onFailedNotify', 0),
            ),
            AccompliEvents::ROLLBACK_RELEASE_FAILED => array(
                array('onFailedNotify', 0),
            ),
        );
    }

    /**
     * Notifies when creating a connection to a Host.
     *
     * @param HostEvent                $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function onCreateConnectionNotify(HostEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $eventDispatcher->dispatch(AccompliEvents::LOG, new LogEvent(LogLevel::INFO, 'Connecting to "{host}".', $eventName, $this, array('host' => $event->getHost()->getHostname())));
    }

    /**
     *
     * @param Event                    $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function onCompleteNotify(Event $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $eventDispatcher->dispatch(AccompliEvents::LOG, new LogEvent(LogLevel::INFO, Accompli::SLOGAN, $eventName, $this));
    }

    /**
     *
     * @param FailedEvent              $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function onFailedNotify(FailedEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $eventDispatcher->dispatch(AccompliEvents::LOG, new LogEvent(LogLevel::ALERT, "Merde...\n{exception}{lastEvent}", $eventName, $this, array('exception' => $event->getException(), 'lastEvent' => get_class($event->getLastEvent()))));
    }
}
