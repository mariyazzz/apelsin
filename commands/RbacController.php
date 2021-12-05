<?php

namespace app\commands;

use app\models\User;
use yii\base\Exception;
use yii\console\Controller;
use yii\rbac\Item;
use yii\rbac\Permission;
use yii\rbac\Role;

class RbacController extends Controller {
  public function actionSetAdmin($id) {
    try {
      \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole(User::ROLE_ADMINISTRATOR), $id);
    } catch (\Exception $e) {
      echo "Failed. {$e->getMessage()}";
    }
  }

  public function actionUpdate() {
    $administrator = $this->addRole(User::ROLE_ADMINISTRATOR);
    $unauthorized = $this->addRole(User::ROLE_UNAUTHORIZED);
    $user = $this->addRole(User::ROLE_USER);
    $rbac = $this->addPermission('rbac');

    $this->addChild($user, $unauthorized);
    $this->addChild($administrator, $user);
    $this->addChild($administrator, $rbac);
  }

  private function addRole(string $name): ?Role {
    $authManager = \Yii::$app->authManager;
    $role = $authManager->getRole($name);
    if (is_null($role)) {
      $role = $authManager->createRole($name);
      try {
        $authManager->add($role);
      } catch (\Exception $e) {
        echo "Add role {$name} Failed. {$e->getMessage()}", PHP_EOL;
        return null;
      }
      echo "Add role {$name} Finished", PHP_EOL;
    } else {
      echo "Role {$name} already exist", PHP_EOL;
    }
    return $role;
  }

  private function addPermission(string $name): ?Permission {
    $authManager = \Yii::$app->authManager;
    if (is_null($permission = $authManager->getPermission($name))) {
      $permission = $authManager->createPermission($name);
      try {
        $authManager->add($permission);
      } catch (\Exception $e) {
        echo "Add permission {$name} Failed. {$e->getMessage()}", PHP_EOL;
        return null;
      }
    }
    return $permission;
  }

  private function addChild(Item $parent, Item $child): bool {
    $authManager = \Yii::$app->authManager;
    if (!$authManager->hasChild($parent, $child)) {
      try {
        $authManager->addChild($parent, $child);
      } catch (Exception $e) {
        echo "Add child {$child->name} Failed. {$e->getMessage()}", PHP_EOL;
        return false;
      }
    }
    return true;
  }
}