<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

// Display the markup.
// @Return array
Public function content() {
  return array(

    '#type'   => 'markup',
    '#markup' => $this->t('Hello, World!'),

    );
  }
}

 ?>
#This code, on its own, will not do anything. It needs to be invoked by adding
#a routing file to our module. Adding the controller first to our code, however,
# is part of a general D8 philosophy of, "Build a tool, then wire it up".
