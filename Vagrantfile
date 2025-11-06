# -*- mode: ruby -*-
# vi: set ft=ruby :

## Essentials informations
project_name = "rewindRadio"
project_url = "rewind.radio"
project_ip = "192.168.33.25"

Vagrant.configure("2") do |config|
  config.vm.box = "debian/bullseye64"

  # Configuration des ports
  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.hostname = project_name + "-vm"
  config.vm.network "private_network", ip: project_ip

  # Creation des dossiers à synchroniser
  config.vm.synced_folder "./home_shared", "/home/vagrant/share", create: true
  config.vm.synced_folder "./clients/#{project_name}", "/var/www/html/#{project_name}", create:true
  
  config.vm.provider "virtualbox" do |provision|
    provision.name = project_name + "-vm"
    provision.memory = "2048"
    provision.cpus = 1
    provision.customize ["modifyvm", :id, "--vram", "48"]
    provision.customize ["modifyvm", :id, "--ioapic", "on"]
    provision.customize ["modifyvm", :id, "--hwvirtex", "on"]
    provision.customize ["modifyvm", :id, "--vtxvpid", "on"]
    provision.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    provision.gui = false
  end

  config.vm.provision "shell", inline: <<-SHELL

  apt-get update

  # Install locales package
  apt-get install -y locales
  
  # Uncomment en_US.UTF-8 for inclusion in generation
  sed -i 's/^# *\(en_US.UTF-8\)/\1/' /etc/locale.gen
  
  # Generate locale
  locale-gen
  
  # Export env vars
  echo "export LC_ALL=en_US.UTF-8" >> ~/.bashrc
  echo "export LANG=en_US.UTF-8" >> ~/.bashrc
  echo "export LANGUAGE=en_US.UTF-8" >> ~/.bashrc


  echo "Update and upgrade packages..."
  sudo apt-get update && sudo apt-get upgrade -y

  echo "Installation et configuration d'Apache..."
  sudo apt-get install apache2 -y
  sudo a2enmod rewrite
  sudo service apache2 restart

  echo "Installation curl et Git..."
  sudo apt-get install curl git -y

  # Clonage du repo de rewindRadio
  cd /var/www/html/
  git clone https://github.com/noordotda/rewindRadio.git

  echo "Création du fichier VirtualHost..."
  touch /etc/apache2/sites-available/#{project_name}.conf

 echo "Insertion des informations du Virtualhost..."
 sudo su 

 echo "<VirtualHost *:80>
 ServerName #{project_url}
 DocumentRoot /var/www/html/#{project_name}/public
 <Directory /var/www/html/#{project_name}>
   AllowOverride All
   Order allow,deny
   Allow from all
 </Directory>
</VirtualHost>
" > /etc/apache2/sites-available/#{project_name}.conf

sudo a2ensite #{project_name}.conf
sudo service apache2 reload

echo "Mise à jour des packages..."
sudo apt update && sudo apt upgrade -y

echo "Installation PHP 8.1 ..."
sudo apt install -y curl lsb-release ca-certificates apt-transport-https software-properties-common gnupg2 -y
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/sury-php.list
sudo wget -qO - https://packages.sury.org/php/apt.gpg | sudo gpg --no-default-keyring --keyring gnupg-ring:/etc/apt/trusted.gpg.d/debian-php-8.gpg --import
sudo chmod 644 /etc/apt/trusted.gpg.d/debian-php-8.gpg
sudo apt update && sudo apt upgrade -y
sudo apt install php8.2 -y
sudo apt install libapache2-mod-php php8.2-cli php8.2-zip php8.2-mbstring php8.2-xml php8.2-common php8.2-curl php8.2-mysql php8.2-gd php8.2-bcmath php8.2-imap php8.2-intl  -y

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
chmod +x /usr/local/bin/composer

cd /var/
php composer-setup.php --install-dir=bin --filename=composer
chmod +x bin/composer
composer self-update

sudo apt install build-essential -y

cd
curl -fsSL https://deb.nodesource.com/setup_current.x | sudo -E bash -
sudo apt-get update
sudo apt install nodejs -y

echo "Installation MariaDB..."
sudo apt-get install apt-transport-https curl -y
sudo curl -o /etc/apt/trusted.gpg.d/mariadb_release_signing_key.asc 'https://mariadb.org/mariadb_release_signing_key.asc'
sudo sh -c "echo 'deb https://ftp.osuosl.org/pub/mariadb/repo/10.6/debian bullseye main' >>/etc/apt/sources.list"
sudo apt update && sudo apt upgrade -y
sudo apt-get install mariadb-server -y

echo "
*******************************************************************************************************

          Votre LAMP Stack de développement est maintenant installée!
          Il ne reste juste à faire <mysql_secure_installation> dans l'invite de commande SSH 
          pour configurer MariaDB correctement.

*******************************************************************************************************

"
SHELL
end
