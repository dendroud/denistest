<?php

namespace Drupal\denistest\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\denistest\Event\UserSubscribeEvent;
use Drupal\user\Entity\User;

/**
 * denistest event subscriber.
 */
class UserSubscribeSubscriber implements EventSubscriberInterface {

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs event subscriber.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * Response event handler.
   *
   * @param \Drupal\denistest\Event\UserSubscribeEvent $event
   *   Response event.
   * 
   * @throws \InvalidArgumentException
   */
  public function subscribeUser(UserSubscribeEvent $event) {
    $variables = $event->getVariables();

  //  dsm($variables['user']);
    
    $user = User::load($variables['user']->id());
    
  //  dsm($user);
    
    if ($user->isAnonymous()) {
      $this->messenger->addMessage('You are not authenticated. Please login first', $this->messenger::TYPE_WARNING);
      return;
    }
    
    $user->addRole('subscriber');
    $user->save();

    $this->messenger->addMessage('Role successfully added');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
        UserSubscribeEvent::DENISTEST_USER_SUBSCRIBE => ['subscribeUser'],
    ];
  }

}
