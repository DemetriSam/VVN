<?php

namespace Drupal\favorites;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class MySimpleCookie
 *
 * @package Drupal\my_cookies
 */

class TheCookie implements EventSubscriberInterface {
    
    
    /**
     * Current request.
     *
     * @var \Symfony\Component\HttpFoundation\Request|null
     */

    protected $request;

    /**
     * Name of the cookie this service will manage.
     *
     * @var string
     */
    protected $cookieName = 'favorites_cookie';

    /**
     * The cookie value that will be set during the respond event.
     *
     * @var mixed
     */
    protected $newCookieValue;

    /**
     * Whether or not the cookie should be updated during the response.
     *
     * @var bool
     */
    protected $shouldUpdateCookie = FALSE;


    /**
     * MySimpleCookie constructor.
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
     *   Request stack service.
     */
    public function __construct(RequestStack $request_stack) {
        $this->request = $request_stack->getCurrentRequest();

    }

    /**
     * Get this cookie's name.
     *
     * @return string
     */
    public function getCookieName() {
        return $this->cookieName;
    }

    /**
     * Get the cookie's value.
     *
     * @return mixed
     *   Cookie value.
     */
    public function getCookieValue() {
        // If we're mid-request and setting a new cookie value, return that new
        // value. This allows other parts of the system access to the most recent
        // cookie value.
        if (!empty($this->newCookieValue)) {
            return $this->newCookieValue;
        }

        return $this->request->cookies->get($this->getCookieName());
    }

    /**
     * Set the cookie's new value.
     *
     * @param mixed $value
     */
    public function setCookieValue($value) {
        $this->shouldUpdateCookie = TRUE;
        $this->newCookieValue = $value;
    }

    /**
     * Whether or not the cookie should be updated during the response.
     *
     * @return bool
     */
    public function getShouldUpdateCookie() {
        return $this->shouldUpdateCookie;
    }

    /**
     * Whether or not the cookie should be deleted during the response.
     *
     * @return bool
     */
    public function getShouldDeleteCookie() {
        return $this->shouldDeleteCookie;
    }

    /**
     * Set whether or not the cookie should be deleted during the response.
     *
     * @param bool $delete_cookie
     *   Whether or not to delete the cookie during the response.
     */
    public function setShouldDeleteCookie($delete_cookie = TRUE) {
        $this->shouldDeleteCookie = (bool) $delete_cookie;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents() {
        return [
            KernelEvents::REQUEST => 'onRequest',
            KernelEvents::RESPONSE => 'onResponse',
        ];
    }

    /**
     * React to the symfony kernel request event.
     *
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     *   The event to process.
     */
    public function onRequest($event) {

        if (!$event->isMasterRequest()) {
          // The request event can fire more than once. Don't do anything if it's
          // not the master request.
          return;
        }
        
        //$value = $this->getCookieValue();
        //$value = (int) $value + 1;
        //$this->setCookieValue($value);
      }

    /**
     * React to the symfony kernel response event by managing visitor cookies.
     *
     * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
     *   The event to process.
     */

    public function onResponse($event) {
        //$this->setCookieValue('test_value');
        $response = $event->getResponse();
        if ($this->getShouldUpdateCookie()) {
            $my_new_cookie = new Cookie($this->getCookieName(), $this->getCookieValue());
            //$response->headers->setCookie($my_new_cookie);
        }

        // The "should delete" needs to happen after "should update", or we could
        // find ourselves in a situation where we are unable to delete the cookie
        // because another part of the system is trying to update its value.
        if ($this->getShouldDeleteCookie()) {
            $response->headers->clearCookie($this->getCookieName());
        }

    }

}