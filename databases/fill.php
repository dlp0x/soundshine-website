<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Classes\StaticContent;

require('../../config/constants.php');
require('../../app/classes/StaticContent.php');

?>
<html>

<head>
    <style>
        pre {
            line-height: 20px;
        }
    </style>
    <?= StaticContent::getStyleSheet(); ?>
    <title><?= _('rewindRadio Installation'); ?></title>
    <title><?= _('rewindRadio Installation'); ?></title>
</head>

<body class="bg-dark">
    <div class='text-center' style="margin:50px 0 0 0;"> <img src="logo.png" width="150px" height="150px" alt="rewindRadio logo"></div>

    <div class="card mx-auto mt-3 card-dark" style="width: 50rem;">
        <div class="card-header">
            <h4><?= _("RewindRadio script Installation process"); ?></h4>
        </div>
        <div class="card-body">
            <pre>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form input
    $hostname = $_POST['hostname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = $_POST['database'];
    $prefix = $_POST['prefix'];
    $addFakeData = isset($_POST['addFakeData']) ? true : false;
    $deleteFakeData = isset($_POST['deleteFakeData']) ? true : false;
    $firstUsername = $_POST['siteUsername'];
    $firstPassword = $_POST['sitePassword'];
    $firstUserEmail = $_POST['userEmail'];
    $site_name = $_POST['site_name'];

    // Connect to the database
    try {
        $conn = new PDO("mysql:host=$hostname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo _(_("Connected to the database."));
        echo "<br>";
    } catch (PDOException $e) {
        die("Error connecting to the database: " . $e->getMessage());
    }
    // Check if the database exists
    $stmt = $conn->prepare("SHOW DATABASES LIKE ?");
    $stmt->execute([$database]);
    // Check if the delete fake data option was selected       
    if (isset($_POST['deleteFakeData'])) {
        // Delete fake data from the tables
        $stmt = $conn->prepare("DELETE * FROM " . $prefix . "_subcategory_info");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE * FROM " . $prefix . "_events_info");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE * FROM events");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE * FROM  " . $prefix . "_posts");
        $stmt->execute();
        echo _("Fake data deleted from the database.");
        echo "<br>";
        echo _("Fake data deleted from the database.");
        echo "<br>";
    }
    // Check if the database exists
    $stmt = $conn->prepare("SHOW DATABASES LIKE ?");
    $stmt->execute([$database]);
    if ($stmt->rowCount() == 0) {

        // Create the database
        $sql = "CREATE DATABASE $database";
        $conn->exec($sql);
        echo _("Database created.");
        echo "<br>";
    } else {
        echo _("The database already exists.");
        echo "<br>";
    }

    // Connect to the database
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo _("Connected to the database.");
    echo "<br>";
    // Check if the tables and columns exist
    $stmt = $conn->prepare("SHOW TABLES LIKE ?");
    $stmt->execute(['subcategory']);
    if ($stmt->rowCount() == 0) {
        echo _("The subcategory table doesn't exists. Please install RadioDJ before executing this setup.");
        echo "<br>";
        die();
    } else {
        echo _("The subcategory table exists. Please proceed.");
        echo "<br>";
    }
    $stmt = $conn->prepare("SHOW TABLES LIKE ?");
    $stmt->execute(['events']);
    if ($stmt->rowCount() == 0) {
        echo _("The events table doesn't exists. Please install RadioDJ before executing this setup.");
        echo "<br>";
        die();
    } else {
        echo _("The events table exists. Please proceed.");
        echo "<br>";
    }

    // Check if the tables and columns exist
    $stmt = $conn->prepare("SHOW TABLES LIKE ?");
    $stmt->execute(['subcategory_info']);
    if ($stmt->rowCount() == 0) {

        // Create the subcategory_info table
        $sql = "CREATE TABLE " . $prefix . "_subcategory_info (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        subcategory_id INT NOT NULL,
        description VARCHAR(200) DEFAULT NULL,
        image VARCHAR(80) DEFAULT NULL,
        guests VARCHAR(20) DEFAULT NULL,
        curator VARCHAR(20) DEFAULT NULL,
        scheduleTime VARCHAR(20) DEFAULT NULL,
        scheduleDay VARCHAR(20) DEFAULT NULL,
        mxcloud VARCHAR(20) DEFAULT NULL,
        theme VARCHAR(80) DEFAULT NULL,
        tags VARCHAR(80) DEFAULT NULL,
        enabled INT(1) DEFAULT NULL,
        backtime DATE DEFAULT NULL,
        is_fake INT(1) DEFAULT 0,
        INDEX (subcategory_id),
        FOREIGN KEY (subcategory_id) REFERENCES subcategory(id)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
";
        $conn->exec($sql);
        echo _("Created the subcategory_info table.");
        echo "<br>";
    } else {
        echo _("The subcategory_info table already exists.");
        echo "<br>";
    }

    // Create the events_info table
    $sql = "CREATE TABLE " . $prefix . "_events_info (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        event_id INT NOT NULL, 
        image VARCHAR(80) DEFAULT NULL,
        guests VARCHAR(20) DEFAULT NULL,
        curator VARCHAR(20) DEFAULT NULL,
        tags VARCHAR(80) DEFAULT NULL,
        is_fake INT(1) DEFAULT 0,
        INDEX (event_id),
        CONSTRAINT FOREIGN KEY (event_id) REFERENCES events(id)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    ";
    $conn->exec($sql);
    echo _("Created the events_info table.");
    echo "<br>";
    // Alter the events table
    $sql = "ALTER TABLE events
    ADD is_fake TINYINT(1) NOT NULL DEFAULT 0;";
    $conn->exec($sql);
    echo _("Alter the events table for detecting the fake events created with this script.<br>We will remove it when you delete the fake content.");
    echo "<br>";
    // Create the likes table
    $sql = "CREATE TABLE " . $prefix . "_likes (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        song_id INT UNSIGNED NOT NULL,
        type ENUM('like','dislike') NOT NULL,
        INDEX(song_id),
        FOREIGN KEY (song_id) REFERENCES songs(id) ON DELETE CASCADE
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
";
    $conn->exec($sql);
    echo _("Created the likes table.");
    echo "<br>";
    // Create the PREFIX_users table
    $sql = "CREATE TABLE " . $prefix . "_users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    last_login DATETIME,
    member_since DATETIME,
    bio VARCHAR(255),
    job_title VARCHAR(255),
    facebook VARCHAR(255),
    instagram VARCHAR(255),
    twitter VARCHAR(255),
    twitch VARCHAR(255),
    tiktok VARCHAR(255),
    snapchat VARCHAR(255),
    discord VARCHAR(255),
    linkedin VARCHAR(255),
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    nice_nickname VARCHAR(255),
    email VARCHAR(255),
    background_image VARCHAR(255),
    fav_quote VARCHAR(255),
    is_fake INT(1) DEFAULT 0,
    shows_id INT,
    posts_id INT
    ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    $conn->exec($sql);
    echo _("Created the new users table. We did a new table to not mess with radioDJ tables.");
    echo "<br>";

    $sql = "CREATE TABLE " . $prefix . "_user_level (
        id INT NOT NULL PRIMARY KEY,
        level_name VARCHAR(20) NOT NULL,
        nice_name VARCHAR(50) NOT NULL,
        id_caps VARCHAR(50) NULL,
        level_ids VARCHAR(50) NULL);";
    $conn->exec($sql);
    echo _("Created the user_level table.");
    echo "<br>";

    $sql = "INSERT INTO " . $prefix . "_user_level (id, level_name, nice_name, level_ids) VALUES
        (1, 'superadmin', 'Administrateur Root',NULL),
        (2, 'administrator', 'Administrateur.trice',NULL),
        (3, 'blogEditor', 'Writer Manager',NULL),
        (4, 'hosteditor', 'Hosts Manager',NULL),
        (5, 'author', 'Auteur.trice',NULL),
        (6, 'host', 'Host / DJ',NULL),
        (7, 'contributor', 'Contributeur.trice',NULL),
        (8, 'subscriber', 'Abonné.e',NULL)";
    $conn->exec($sql);

    echo _("Insert the user levels.");
    echo "<br>";

    $sql = "CREATE TABLE " . $prefix . "_capabilities (
        `id` int(11) NOT NULL,
        `capability` varchar(50) NOT NULL,
        `nice_capname` varchar(50) NOT NULL
      );";
    $conn->exec($sql);
    echo _("Created the capabilities table.");
    echo "<br>";
    $sql = "INSERT INTO " . $prefix . "_capabilities (id, capability, nice_capname) VALUES
      (1, 'create_post', 'Créer un article'),
      (2, 'edit_post', 'Éditer un article'),
      (3, 'publish_post', 'Publier un article'),
      (4, 'propose_post', 'Proposer un article'),
      (5, 'delete_propose_post', 'Supprimer une proposition'),
      (6, 'edit_propose_post', 'Éditer une proposition'),
      (7, 'edit_all_post', 'Voir tous les articles'),
      (8, 'delete_post', 'Supprimer un article'),
      (9, 'manage_categories', 'Gérer les catégories'),
      (10, 'upload_avatar', 'Téléverser un avatar'),
      (11, 'upload_background', 'Téléverser une image de fond'),
      (12, 'create_profile', 'Créer un utilisateur'),
      (13, 'edit_profile', 'Éditer mon profil'),
      (14, 'delete_profile', 'Supprimer mon profil'),
      (15, 'publish_profile', 'Activer un profil'),
      (16, 'add_episode', 'Ajouter un épisode'),
      (17, 'delete_episode', 'Supprimer un épisode'),
      (18, 'overwrite_episode', 'Écraser un épisode'),
      (19, 'create_show_page', 'Créer une page d\'émission'),
      (20, 'publish_show', 'Publier une page d\'émission'),
      (21, 'edit_show_page', 'Éditer une page d\'émission'),
      (22, 'delete_show_page', 'supprimer une page d\'émission');";
    $conn->exec($sql);
    echo _("Inserted the capabilities.");
    echo "<br>";
    // Create the news categories tables
    $sql = "CREATE TABLE " . $prefix . "_categories (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    is_fake INT(1) DEFAULT 0,
    slug VARCHAR(255) NOT NULL
    ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    $conn->exec($sql);
    echo _("Created the categories table.");
    echo "<br>";
    // Create the news tags tables
    $sql = "CREATE TABLE " . $prefix . "_tags (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    is_fake INT(1) DEFAULT 0,
    slug VARCHAR(255) NOT NULL
    ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    $conn->exec($sql);
    echo _("Created the tags table.");
    echo "<br>";
    // Create the news posts tables
    $sql = "CREATE TABLE " . $prefix . "_posts (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        date_posted DATETIME DEFAULT NULL,
        posted_by INT DEFAULT NULL,
        slug VARCHAR(255) NOT NULL,
        featured_image VARCHAR(255) DEFAULT NULL,
        post_type VARCHAR(255) DEFAULT NULL,
        category_id INT DEFAULT NULL,
        tag_id INT DEFAULT NULL,
        is_fake INT DEFAULT '0',
        is_featured INT DEFAULT NULL,
        PRIMARY KEY (id),
        KEY fk_posted_by (posted_by),
        CONSTRAINT fk_posted_by FOREIGN KEY (posted_by) REFERENCES users (id)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
      ";
    $conn->exec($sql);
    echo _("Created the posts table.");
    echo "<br>";
    $sql = "CREATE TABLE " . $prefix . "_post_categories (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        post_id INTEGER NOT NULL,
        category_id INTEGER NOT NULL,
        is_fake INT(1) DEFAULT 0,
        FOREIGN KEY (post_id) REFERENCES " . $prefix . "_posts(id),
        FOREIGN KEY (category_id) REFERENCES " . $prefix . "_categories(id)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
    ";
    $conn->exec($sql);
    echo _("Created the post_categories table.");
    echo "<br>";
    $sql = "CREATE TABLE " . $prefix . "_post_tags (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        post_id INTEGER NOT NULL,
        tag_id INTEGER NOT NULL,
        is_fake INT(1) DEFAULT 0,
        FOREIGN KEY (post_id) REFERENCES " . $prefix . "_posts(id),
        FOREIGN KEY (tag_id) REFERENCES " . $prefix . "_tags(id)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
    ";
    $conn->exec($sql);
    echo _("Created the post_tags table.");
    echo "<br>";
    // Insert fake data (optional)
    if ($addFakeData) {
        $sql = "INSERT INTO " . $prefix . "_subcategory_info (subcategory_id, description, image, guests, curator, scheduleTime, scheduleDay, mxcloud, theme, tags, enabled, backtime)
    VALUES (18, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'fake-image-1.jpg', '2-4', 'John Smith', '20:00', 'Monday', 'mxcloud1', 'Nature', 'outdoor, adventure', 1, '2022-01-01')";
        $conn->exec($sql);

        $sql = "INSERT INTO " . $prefix . "_subcategory_info (subcategory_id, description, image, guests, curator, scheduleTime, scheduleDay, mxcloud, theme, tags, enabled, backtime)
    VALUES (19, 'Suspendisse potenti. In hac habitasse platea dictumst.', 'fake-image-2.jpg', '4-6', 'Jane Doe', '19:00', 'Wednesday', 'mxcloud2', 'Arts', 'painting, music', 1, '2022-02-01')";
        $conn->exec($sql);

        $sql = "INSERT INTO " . $prefix . "_subcategory_info (subcategory_id, description, image, guests, curator, scheduleTime, scheduleDay, mxcloud, theme, tags, enabled, backtime)
    VALUES (30, 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.', 'fake-image-3.jpg', '6-8', 'Bob Johnson', '21:00', 'Friday', 'mxcloud3', 'Food', 'cooking, wine tasting', 1, '2022-03-01')";
        $conn->exec($sql);
        echo _("Added fake data to the subcategory_info table.");
        echo "<br>";
        $sql = "INSERT INTO events_categories (ID, NAME) 
        VALUES(99, 'Website Events'),
        (98, 'Schedule Events');";
        $conn->exec($sql);
        echo _("Added the events categories for the website events.");
        echo "<br>";
        $sql = "INSERT INTO events ( ID, TYPE, TIME, NAME, DATE, DAY, hours, DATA, enabled, catID, smart, is_fake ) 
        VALUES(99, 0, '21:00:00', 'First Fake Event', '2023-06-18', '&6', '&20', 'Clear Playlist!', TRUE, 99, FALSE, 1 ),
        (98, 0, '15:00:00', 'Second Fake Event', '2023-01-27', '&3', '&18', 'Clear Playlist!', TRUE, 99, FALSE, 1 ),
        (97, 0, '15:00:00', 'Third Fake Event', '2023-01-25', '&4', '&19', 'Clear Playlist!', TRUE, 99, FALSE, 1 ),
        (96, 0, '20:00:00', 'First Fake Event', '2023-06-18', '&6', '&20', 'Clear Playlist!', TRUE, 98, FALSE, 1 ),
        (95, 0, '21:00:00', 'Second Scheduled Fake Event', '2023-06-18', '&6', '&20', 'Clear Playlist!', TRUE, 98, FALSE, 1 ),
        (94, 0, '22:00:00', 'Third Scheduled Fake Event', '2023-06-18', '&6', '&20', 'Clear Playlist!', TRUE, 98, FALSE, 1 );";
        $conn->exec($sql);

        $sql = "INSERT INTO " . $prefix . "_events_info (event_id, image, guests, curator, tags) VALUES (99, 'fake-image-1.jpg', '', 'John Smith', 'Nature, outdoor, adventure'),
        (98, 'fake-image-2.jpg', '', 'Jane Doe', 'painting, music'),
        (97, 'fake-image-3.jpg', '', 'Bob Johnson', 'Food, cooking, wine tasting'),
        (96, 'fake-image-3.jpg', '', 'Osakari Yasuhiro', 'Food, cooking, wine tasting'),
        (95, 'fake-image-3.jpg', '', 'Johanna Strub', 'Food, cooking, wine tasting'),
        (94, 'fake-image-3.jpg', '', 'Mia Johnson', 'Food, cooking, wine tasting')";
        $conn->exec($sql);
        echo _("Added fake data to the events_info table.");
        echo "<br>";
        $sql = "INSERT INTO " . $prefix . "_posts (title, content, date_posted, posted_by, slug, featured_image, post_type,category_id, tag_id, is_fake, is_featured)
    VALUES ('Évènement à venir à la radio', 'Notre webradio prépare un événement passionnant pour les amateurs de musique. Rejoignez-nous pour un week-end de musique non-stop! La prochaine grande chose à laquelle nous travaillons est un festival de musique en direct qui aura lieu les [dates]. Ce sera un week-end de musique non-stop, avec des artistes talentueux qui viendront sur scène pour vous offrir les meilleures performances. Cette année, nous avons une ligne incroyable d\'artistes, y compris [nom d\'artistes]. Ne manquez pas l\'occasion d\'assister à ce festival en direct et de vibrer au son de la musique. Rejoignez-nous pour célébrer la musique et passer un week-end inoubliable!', NOW(), '1', 'event-to-our-radio', 'pexels-taryn-elliott-6829488.jpg',1,1,1,1,0),

    ('Bénévolat chez rewindRadio', 'Un billet sur un événement passé à la radio :
    Nous venons de vivre un événement incroyable à notre webradio. Jetez un coup d\oeil à quelques moments clés de cette soirée mémorable.
    
    La semaine dernière, nous avons eu le plaisir d\'accueillir [nom d\'artiste] en direct à notre studio pour un concert exceptionnel. Cette soirée était remplie d\'énergie et de musique enivrante, et nous sommes ravis de partager quelques-uns de nos moments préférés avec vous.
    
    caption: [Nom de l\'artiste] en train de donner un spectacle époustouflant sur scène.
    Ce fut une soirée incroyable et nous remercions [nom de l\'artiste] pour ce moment mémorable.', NOW(), '1', 'chez-rewindradio', 'pexels-nati-14642654.jpg',1,1,1,1,0),
    
    ('Bénévolat chez rewindRadio', '<p>Vous souhaitez vous investir dans votre communauté et faire une différence dans votre ville? Rejoignez notre équipe de bénévoles pour notre organisme de radio communautaire!
    </p><p>
    En tant que bénévole, vous aurez la chance de participer à la création de contenu passionnant et de contribuer à l\'animation de notre radio. Que vous soyez passionné de musique, de journalisme ou que vous cherchiez simplement à vous faire de nouveaux amis, nous avons une place pour vous.
    
    </p><p>Le bénévolat pour notre radio communautaire est une expérience enrichissante qui vous permettra de développer de nouvelles compétences, de rencontrer de nouvelles personnes et de contribuer à votre communauté. Alors n\'hésitez pas à nous contacter pour en savoir plus sur les opportunités de bénévolat disponibles. Nous espérons vous voir bientôt!</p>', NOW(), '1', 'privacy-policy', 'pexels-nati-14642654.jpg',2,1,1,1,0),

    ('Politique de confidentialité', '<p>Nous ne pouvons pas vous fournir de lien vers un modèle de politique de confidentialité, mais voici quelques éléments à inclure dans une politique de confidentialité pour une webradio :</p>
<ul>
   <li>Présentation de votre entreprise et de votre webradio, y compris les coordonnées et les informations de contact.</li>
   <li>Description de la manière dont vous collectez, utilisez et partagez les données de vos utilisateurs, y compris les données collectées par les cookies et les technologies de suivi.</li>
   <li>Description de vos pratiques de sécurité pour protéger les données de vos utilisateurs.</li>
   <li> Informations sur vos politiques de confidentialité en matière de publicité en ligne et de ciblage des annonces.</li>
   <li> Informations sur vos pratiques en matière de notification des changements apportés à votre politique de confidentialité.</li>
   <li> Informations sur vos pratiques en matière de gestion des droits des utilisateurs en ce qui concerne leurs données personnelles.</li>
   <li> Informations sur la manière dont vous gérez les plaintes et les demandes de vos utilisateurs en matière de confidentialité.</li>
   <li> Informations sur la loi applicable et sur la manière dont vous gérez les différends éventuels.</li></ul>
   <p> Il est important de se rappeler que chaque pays et chaque région ont leurs propres lois et réglementations en matière de confidentialité, il est donc important de consulter un avocat pour vous assurer que votre politique de confidentialité est conforme aux lois en vigueur.', NOW(), '1', 'privacy-policy', 'pexels-nati-14642654.jpg',2,1,1,1,0);";
        $conn->exec($sql);
        echo _("Added fake data to the post table.");
        echo "<br>";
        $sql = "INSERT INTO " . $prefix . "_users( username, PASSWORD, avatar, last_login, member_since, bio, job_title, facebook, twitter, instagram, twitch, tiktok, discord, linkedin, first_name, last_name, nice_nickname, email, background_image, fav_quote, is_fake) 

VALUES ('$firstUsername', '$firstPassword', 'AvatarMaker-03.png', NULL, NULL, 'My bio', 'Founder & CEO', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'Osakari', 'Yasuhiro', 'Osakari Yasuhiro', '$firstUserEmail' , 'background_image.jpg', 'Be yourself. Everyone else is already taken. ― Oscar Wilde', 0),

('Gallo2002', 'Iethue9ohph', 'AvatarMaker.png', '2016-02-09 21:12:40', '2016-01-10 14:52:54', 'Certified explorer. Beer scholar. Food expert. Bacon lover. Creator. Troublemaker. Music junkie.', 'Directrice de création', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'rewindRadio', 'rewindRadio','rewindRadio', 'Jennifer', 'Galloway', 'Jennifer Galloway', 'gallo2002@example.com', 'background_image', 'Create with the heart; build with the mind.', 0),

('john_doe', 'password1', 'AvatarMaker01.png', '2022-12-01 10:00:00', '2022-10-01 10:00:00', 'John Doe is a software engineer with 5 years of experience.', 'Software Engineer', 'https://facebook.com/johndoe', 'https://twitter.com/johndoe', 'https://instagram.com/johndoe', 'https://twitch.com/johndoe', 'https://tiktok.com/johndoe', 'https://discord.com/johndoe', 'https://linkedin.com/johndoe', 'John', 'Doe', 'John Doe', 'john.doe@example.com', 'https://example.com/background1.jpg', 'Code is poetry.', 0),

('jane_doe', 'password2', 'AvatarMaker02.png', '2022-11-15 12:00:00', '2022-09-01 10:00:00', 'Jane Doe is a graphic designer with 7 years of experience.', 'Graphic Designer', 'https://facebook.com/janedoe', 'https://twitter.com/janedoe', 'https://instagram.com/janedoe', 'https://twitch.com/janedoe', 'https://tiktok.com/janedoe', 'https://discord.com/janedoe', 'janedoe', 'Jane', 'Doeker', 'Jane Doeker', 'jane.doe@example.com', 'https://example.com/background2.jpg', 'Design is not just what it looks like and feels like. Design is how it works.', 0);";

        $conn->exec($sql);
        echo _("Added fake data to the users table. Don't worry, it won't mess with rdj users table.");
        echo "<br>";
        $sql = "INSERT INTO " . $prefix . "_categories (name, slug) VALUES('News', 'news'), ('Tech', 'tech'), ('Entertainment', 'entertainment')";
        $conn->exec($sql);
        echo _("Added fake data to the categories table.");
        echo "<br>";
    }

    // Create the insert_subcategory_info trigger
    $sql = "DROP TRIGGER IF EXISTS insert_subcategory_info;
    CREATE TRIGGER insert_subcategory_info
    AFTER INSERT ON subcategory
    FOR EACH ROW
    BEGIN
    INSERT INTO " . $prefix . "_subcategory_info (subcategory_id)
    VALUES (NEW.id);
    END";
    $conn->exec($sql);
    echo _("Created the insert_subcategory_info trigger.");
    echo "<br>";
    // Create the insert_subcategory_info trigger
    $sql = "DROP TRIGGER IF EXISTS insert_event_info;
    CREATE TRIGGER insert_event_info AFTER INSERT ON events FOR EACH ROW
    INSERT INTO " . $prefix . "_events_info(event_id)
    VALUES(NEW.id);";
    $conn->exec($sql);
    echo _("Created the insert_events_info trigger.");
    echo "<br>";
    // Append the database constants to the config.php file
    $config = "<?php\n";
    $config .= "// Configuration de la base de données - Database configuration\n";
    $config .= "define('PREFIX', '{$prefix}');\n";
    $config .= "define('DBHOST', '{$hostname}');\n";
    $config .= "define('DBNAME', '{$database}');\n";
    $config .= "define('DBUSER', '{$username}');\n";
    $config .= "define('DBPASSWORD', '{$password}');\n\n";
    $config .= "// Nom et langue du site web - Name & Language of the website\n";
    $config .= "define('SITE_NAME', '{$site_name}');\n";
    $config .= "define('LANG', 'fr');";
    $config .= "define('LANG', 'fr');";
    $config .= "?>";
    file_put_contents('../../config/config.php', $config, FILE_APPEND);

    echo _('Setup completed successfully!') . "***** N'oubliez SURTOUT pas de déplacer/supprimer le dossier setup du dossier public. **** </pre> 
    <a href='/'><button class='btn btn-dark'>" . _('Go to your website') . "</button></a>";
}
?>
    </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</body>
</html>