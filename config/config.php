<?php
// Configuration de la base de données - Database configuration
// NOTE: encore utilisée par les sections admin (App\Classes\Admin/Login/User),
// qui restent hors du périmètre de l'issue #1 (pages publiques uniquement).
define('PREFIX', 'z');
define('DBHOST', '10.0.0.202');
define('DBNAME', 'radiodj_sys');
define('DBUSER', 'noordotda');
define('DBPASSWORD', 'codeine');

// Configuration de l'API radiodj-api - radiodj-api connection settings
// Les pages publiques (accueil, chansons, dédicaces, émissions, événements,
// équipe, blogue) passent par cette API plutôt que par un accès direct à la
// base RadioDJ. Les identifiants peuvent être surchargés via variables
// d'environnement pour éviter de les committer en clair.
define('RADIODJ_API_URL', getenv('RADIODJ_API_URL') ?: 'http://10.0.0.219:3001/api');
define('RADIODJ_API_KEY', getenv('RADIODJ_API_KEY') ?: 'rBbIW8XFcAcDLWulPGcaeXM38ffMcjvrsFaHy0xFR1JCvmlt5wRVH5SVIjZTOR');
define('RADIODJ_API_TIMEOUT', 5); // secondes

// Nom et langue du site web - Name & Language of the website
define('SITE_NAME', 'soundSHINE Radio');
define('LANG', 'en');
