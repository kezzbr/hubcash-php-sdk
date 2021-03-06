<?php

namespace Hubcash;

/**
 * Class Notification
 * @package Hubcash
 */
class Notification extends Hubcash
{

    // Notification manager URL
    const NOTIFICATIONS_URL = self::ENDPOINT . '/notifications';

    /**
     * @var $NotificationId string
     */
    public $NotificationId;

    /**
     * @var $DateUpdated string
     */
    public $DateUpdated;

    /**
     * @var $DateAdded string
     */
    public $DateAdded;

    /**
     * @var $LastResponseCode string
     */
    public $LastResponseCode;

    /**
     * @var $Sale NotificationSale
     */
    public $Sale;

    /**
     * @var array
     */
    public $_hiddenSet = [
        'NotificationId',
    ];

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->Sale = new NotificationSale();
    }

    /**
     * Retrieve notifications list, with pagination assets
     * @param null $page
     * @return Notification[]
     */
    public function getNotifications($page = null)
    {
        $url = self::NOTIFICATIONS_URL;
        $url .= !empty($page) ? "?pg={$page}" : "";

        $return = $this->sendRequest(self::REQUEST_GET, $url);
        $notificationsArray = !empty($return['Notifications']) ? $return['Notifications'] : array();

        /** @var $Notifications []Notification */
        $Notifications = array();

        // Add received notifications into array of Notification
        foreach ($notificationsArray as $key => $notification) {
            $Notification = new Notification($this->_code, $this->_token);
            $Notification->ArrayToObject($notification);
            $Notifications[$key] = $Notification;
        }

        return $Notifications;
    }


    /**
     * Retrieve a single notification by identifier
     * @param $id
     * @return Notification
     */
    public function getNotification($id)
    {
        $return = $this->sendRequest(self::REQUEST_GET, self::NOTIFICATIONS_URL . "/{$id}");
        return $this->ArrayToObject($return['Notification']);
    }


    /**
     * @param array $data
     * @return Notification
     */
    public function ArrayToObject(Array $data)
    {
        $this->NotificationId = !empty($data['NotificationId']) ? $data['NotificationId'] : null;
        $this->DateUpdated = !empty($data['DateUpdated']) ? $data['DateUpdated'] : null;
        $this->DateAdded = !empty($data['DateAdded']) ? $data['DateAdded'] : null;
        $this->LastResponseCode = !empty($data['LastResponseCode']) ? $data['LastResponseCode'] : null;

        // The notification can contain additional data,
        // provided for another records in the API, with uses his identifiers
        // and some data that has ben changed.

        // Add the NotificationSale
        if (!empty($data['Sale'])) {
            $this->Sale->ArrayToObject($data['Sale']);
        } else {
            unset($this->Sale);
        }

        return $this;
    }

}