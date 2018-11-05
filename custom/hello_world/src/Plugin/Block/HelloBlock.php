<?php
// Please note that this is a plugin for the module hello_world.
// blocks in Drupal 8 are instances of the block plugin. The Drupalblock manager
// scans your modules for any classes that contain a @Block Annotation.
//
// This example makes use of the @Block annotation along with the properties
// "id" and "admin_label" to define a custom block.

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;

// "updated" statements to add block configuration

use Drupal\Core\Block\BlockPluginInterface;
// BlockPluginInterface Defines the required interface for all block plugins.

use Drupal\Core\Form\FormStateInterface;
// Provides an interface for an object containing the current state of a form.

// This is passed to all form related code so that the caller can use it to examine
// what in the form changed when the form submission process is complete.
// Furthermore, it may be used to store information related to the processed data
// in the form, which will persist across page requests when the 'cache' or
// 'rebuild' flag is set. See \Drupal\Core\Form\FormState::$internalStorage for
// documentation of the available flags.

/**
* Provides a 'Hello' block
*
*@Block(
*   id = "hello_block",
*   admin_label = @Translation("Hello block"),
*   category = @Translation("Hello World"),
*
*)
*/

class HelloBlock extends BlockBase implements BlockPluginInterface {
// Defines a base block implementation that most blocks plugins will extend.
// This abstract class provides the generic block configuration form, default block
// settings, and handling for general user-defined block visibility settings.

/**
* {@inheritdoc}
*/
// public function build() {
//   return array (
//     '#markup' => $this ->t('Hello, World!'),
//   );
//  }
// ..(this used to be the starting point to just add the hello world markup)
// To make use of the configuration of instances of the block, we can modify
// the build() method of the HelloBlock class:



  // extends is for inheritance, i.e. inheriting the methods/fields from the class.
  // A PHP class can only inherit from one class. implements is for implementing
  // interfaces. It simply requires the class to have the methods which are defined
  // in the implemented interfaces

/**
*{@inheritdoc}
*/
// {@inheritdoc} as being the sole thing in a doc block on a method of a class,
// meaning "Inherit the documentation from a parent class/interface".
//
// This is very useful as it is, but we also have a lot of cases where it would be
//  nice to say "Inherit most of the docs, but override this one part" or "Inherit
//   all of the docs, but add another piece to the end".
  public function blockForm ($form, FormStateInterface $form_state){
    // The form is first defined by the reference to its parent class
    $form = parent::blockForm($form, $form_state);
//  adding a new field to the form. This process is called polymorphism and is
// one of the important advantages of using Object-Oriented Programming(OOP)
    $config = $this->getConfiguration();

    $form['hello_block_name'] = array(

      '#type'          => 'textfield',
      '#title'         => $this->t('Who'),
      '#description'   => $this->t('Who do you want to say hello to?'),
      '#default_value' => isset($config['hello_block_name'])?

      $config['hello_block_name'] : '',

    );
    return $form;
  }
  // Next, we have to tell Drupal to save the values from our form into the
  // configuration for this block. Here is an example:

  /**
  * {@inheritdoc}
  */
  public function blockSubmit ($form, FormStateInterface $form_state){
    parent::blocksubmit($form, $form_state);
   $this->configuration['hello_block_name'] = $form_state->getValue('hello_block_name');
  }

// could have also be written:
// public function blockSubmit ($form, FormStateInterface $form_state){
//   parent::blocksubmit($form, $form_state);
// $values = $form_state->getValues();
// $this->configuration['hello_block_name'] =
// $values('hello_block_name');
//   }

// If you have a fieldset wrapper around your form elements then you should pass
// an array to the getValue() function, instead of passing the field name alone.
// Here myfieldset is the fieldset which is wrapping the hello_block_name field.
// $this->configuration['hello_block_name'] = $form_state->getValue(array
// ('myfieldset', 'hello_block_name'));

// Adding this code will mean that the form will process, and the input to the form
// will be saved in the configuration for that instance of the block, independent
// of the other instances of the block. The block is still not making use of the
// results of the configuration change, however. That is in the next book page.
/**
  * {@inheritdoc}
  */
 public function defaultConfiguration() {
   $default_config = \Drupal::config('hello_world.settings');
   return [
     'hello_block_name' => $default_config->get('hello.name'),
   ];
 }

 // This method is the one that makes use of the value stored in the drupal object.

public function build(){
  $config = $this->getConfiguration();
  // BlockBase::getConfiguration() array An array of this plugin's configuration.

  if(!empty($config['hello_block_name'])){
    $name = $config['hello_block_name'];
  }else{
    $name = $this->t('to no one');
  }
  return array(
    '#markup' => $this->t('Hello @name!', array(
      '@name' => $name
    )),
  );
}

}

// return [
//  '#theme'=> 'module_theme_id',
//  '#someVariable' => $some_variable,
//  '#attached'     => array(
//       'library'  => array(
//         'my_module/library_name',
//       ),
//     ),
//  ];
// ..............
// attach a library:
// .................
// return [
//  '#theme'=> 'module_theme_id',
//  '#markup' => $this->t('Hello @name!', array(
//    '@name' => $name
//  '#attached'     => array(
//       'library'  => array(
//         'my_module/library_name',
//       ),
//     ),
//  ];
//
// }
