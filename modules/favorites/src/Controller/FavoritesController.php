<?php
namespace Drupal\favorites\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\favorites\TheCart;


/**
 * Provides route responses for the my_cart module.
 */
class FavoritesController extends ControllerBase {

    protected $cart;

    public function __construct() {
        
    }
    


    
    
    public function rendernodes() {

        $cookie_value = \Drupal::service('the_cookie')->getCookieValue();
        $nid_array = explode(',', $cookie_value);
        foreach ($nid_array as $nid) {
            # Get NID render
            $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
            if($node) {
                $nodeToRender = \Drupal::entityTypeManager()->getViewBuilder('node')->view($node, 'teaser');
                $node_markup = \Drupal::service('renderer')->render($nodeToRender);
                $markup[] = $node_markup;
            }


            
        }
        if (!$markup) {
            return [
                '#theme' => 'favorites',
                '#nodes' => $this->t('В корзине нет товаров'),

              ]; 
        }
        return [
            '#theme' => 'favorites',
            '#nodes' => $markup,
          ]; 
    }

    public function addtocart($nid) {
        \Drupal::service('the_cart')->updateTheCookie($nid);
        //\Drupal::service('the_cookie')->setCookieValue($nid);
        $response = new AjaxResponse();
        //$response->addCommand(new AlertCommand('Hello ' .$nid));
        $response->addCommand(new InvokeCommand(NULL, 'myAjaxCallback', ['This is the new text!']));
        return $response;

    }

}