#!/bin/bash
###
## @daminux | damien.pichevin@gmail.com
###

set -e


# Obtenir l'utilisateur en cours
currentUser=$(whoami)

# Obtenir le dossier de travail actuel
currentDir=$(pwd)

# Obtenir le dossier personnel de l'utilisateur en cours
homeDir=$(eval echo ~$currentUser)


# Vérifier si le fichier de verrouillage existe
if [ -f "/var/lock/rundocker.lock" ]; then
  echo "Installation déjà effectuée."
  exit 1
fi


# Créer le raccourci rundocker 
if [ ! -f "/usr/local/bin/rundocker" ]; then
  sudo ln -s $currentDir/buildAndRun.sh /usr/local/bin/rundocker
fi
sudo chmod u+x  /usr/local/bin/rundocker

# créé le dossier des 
sudo  mkdir -p $homeDir/www

# affect les droits du  user et www-data
sudo setfacl -R -d -m u:$currentUser:rwx $homeDir/www
sudo setfacl -R -d -m u:www-data:rwx $homeDir/www
sudo setfacl -R -m u:$currentUser:rwx $homeDir/www
sudo setfacl -R -m u:www-data:rwx $homeDir/www

sudo mkdir -p /var/lock/
sudo touch  /var/lock/rundocker.lock
