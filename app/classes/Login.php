<?php

namespace App\Classes;
/*
// Fonction de connexion
function login($username, $password) {
  // Si le nom d'utilisateur et le mot de passe sont "admin", la connexion est réussie
  if ($username === 'admin' && $password === 'admin') {
    // Enregistrez l'identifiant de l'utilisateur dans la session et renvoyez vrai
    session_start();
    $_SESSION['user_id'] = 1;
    return true;
  } else {
    // Échec de la connexion
    return false;
  }
}

// Fonction de déconnexion
function logout() {
  // Démarrez la session et supprimez l'identifiant de l'utilisateur de la session
  session_start();
  unset($_SESSION['user_id']);
} */

use App\Classes\Database as Database;

class Login
{
  public static function login($username, $password)
  {
    // Démarrer la session

    // Connecter à la base de données
    $db = new Database();
    $db_conx_rdj = $db->connect();

    // Vérifiez les informations de connexion de l'utilisateur
    $query = "SELECT * FROM " . PREFIX . "_users WHERE username = :username AND password = :password";
    $statement = $db_conx_rdj->prepare($query);
    $statement->execute([':username' => $username, ':password' => $password]);
    $row = $statement->fetch(\PDO::FETCH_ASSOC);

    // Si les informations de connexion sont valides
    if ($row) {
      // Enregistrez l'identifiant de l'utilisateur dans la session
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['logged_in'] = true;
      echo "logged_user";
    } else {
      // Échec de la connexion, renvoyez un message d'erreur
      return false;
    }
  }



  public static function logout()
  {
    // Supprimez l'identifiant de l'utilisateur de la session
    unset($_SESSION['user_id']);
  }
}
