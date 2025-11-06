<?php

namespace App\Classes;

use App\Classes\Database;

class User
{
  public static function getAvatar()
  {
    global $router;
    $user_id = 1;      // Retrieve user information from the database
    $db = new Database;
    $db_conx_rdj = $db->connect();
    $query = "SELECT * FROM " . PREFIX . "_users WHERE id = :id";
    $statement = $db_conx_rdj->prepare($query);
    $statement->execute([':id' => $user_id]);
    $user = $statement->fetch(\PDO::FETCH_ASSOC);
    echo '
      <div class="dropdown dropstart">
      <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="/uploads/profile/' . $user['avatar'] . '" alt="' . $user['username'] . '" class="avatar rounded-circle mx-3" width="32" height="32">
      </div>

    <ul class="dropdown-menu text-small">
      <li><a class="dropdown-item" href="' . $router->generate('post-list') . '">' . _("Articles") . '</a></li>
      <li><a class="dropdown-item" href="' . $router->generate('post-add') . '">' . _("Write an article") . '</a></li>
      <li><a class="dropdown-item" href="' . $router->generate('add-draft') . '">' . _("Add a draft") . '</a></li>
      <li><a class="dropdown-item" href="' . $router->generate('view-drafts') . '">' . _("View my drafts") . '</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="' . $router->generate('user-add') . '">' . _("Add a user") . '</a></li>
      <li><a class="dropdown-item" href="' . $router->generate('user-list') . '">' . _("View userlist") . '</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="' . $router->generate('profile', ['id' => $user_id]) . '">' . _("View profile") . '</a></li>
      <li><a class="dropdown-item" href="' . $router->generate('settings') . '">' . _("Settings") . '</a></li>
      <li><a class="dropdown-item" href="' . $router->generate('logout') . '">' . _("Logout") . '</a></li>
    </ul>
  </div>';
  }
}
