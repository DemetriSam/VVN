<?php

namespace Drupal\favorites;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\favorites\TheCookie;

class TheCart implements EventSubscriberInterface {

    protected $request;
    protected $cookie;

    const DEL = ',';
    
    public function __construct() {
        $this->request = \Drupal::service('request_stack');
        $this->cookie = \Drupal::service('the_cookie');
    }



    public function wasItAdded($nid, $current_value) {
        $wasItadded = FALSE;
        $del = self::DEL;
        $arr = explode($del, $current_value);
        foreach ($arr as $key => $value) {
            if ($value == $nid) {
                $wasItadded = TRUE;
            }
        }
        return $wasItadded;
    }

    public function updateTheCookie($nid) {
        $del = self::DEL;
        $current_value = $this->cookie->getCookieValue();
        if(!$this->wasItAdded($nid, $current_value)) {
            if($current_value) {
                $this->cookie->setCookieValue($current_value.$del.$nid);
            } else {
                $this->cookie->setCookieValue($nid);
            }
        } else {
            $new_value = $this->deleteNid($nid, $current_value);
            $this->cookie->setCookieValue($new_value);
        }

        
        
    }

    public function deleteNid($nid, $current_value) {
        $del = self::DEL;
        $arr = explode($del, $current_value);
        if(!isset($arr[1])) {
            return 'x'; //TheCookie не устанавливает пустое значение, поэтому так
        }
        foreach ($arr as $key => $value) {
            if($value == $nid) {
                unset($arr[$key]);
            }
        }

        $new_value = implode($del, $arr);
        return $new_value;
    }

    public function whatToDo() {

    }

    

    public static function getSubscribedEvents() {
        return [
            KernelEvents::REQUEST => 'onRequest',
            KernelEvents::RESPONSE => 'onResponse',
        ];
    }

    public function onRequest($event) {
        if (!$event->isMasterRequest()) {
          // The request event can fire more than once. Don't do anything if it's
          // not the master request.
          return;
        }


    }

    public function onResponse($event) {

    }


}