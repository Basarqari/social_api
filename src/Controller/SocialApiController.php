<?php

/**
 * Contains Drupal\social_api\Controller\SocialApiController
 */

namespace Drupal\social_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Menu\LocalTaskManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SocialApiController extends ControllerBase
{
  /**
   * @var LocalTaskManager
   */
  private $localTaskManager;

  /**
   * @param ContainerInterface $container
   * @return static
   */
  public static function create(ContainerInterface $container)
  {
    $localTaskManager = $container->get('plugin.manager.menu.local_task');

    return new static($localTaskManager);
  }

  /**
   * SocialApiController constructor.
   * @param LocalTaskManager $localTaskManager
   */
  public function __construct(LocalTaskManager $localTaskManager)
  {
    $this->localTaskManager = $localTaskManager;
  }

  public function pluginsPage($route)
  {
    $build = [
      '#theme' => 'plugins_list',
    ];

    $definitions = $this->localTaskManager->getDefinitions();

    $dependencies = array();

    foreach($definitions as $key => $definition) {
      if($definition['base_route'] == $route) {
        $dependencies[$key]['route_name'] = $definition['route_name'];
        $dependencies[$key]['title'] = $definition['title']->render();
      }
    }

    $build['#plugins'] = $dependencies;

    return $build;


    var_dump($dependencies);
  }
}