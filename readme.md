# Information.
- Projet docker stack negocian.cloud plateform : 
- nginx, php7.2, php8.1, mysql, phmyadmin, mongo, elastic, kibana, mailhoc, minidns

# Pré-requis

## WSL
1. wsl 2 installé avec une version d'ubuntu récente exemple : 22.04.x
2. git (sudo apt install git)
3. Préalablement chargé la clé privé d'accés aux repos negocian.cloud.
	- Pour ajouter l'agent SSH à votre `.bashrc` avec votre clé privé au démarrage du terminal wsl, copiez et collez la ligne suivante :
    	```bash
    	echo -e "eval \$(ssh-agent -s)\nssh-add ~/.ssh/id_rsa" >> ~/.bashrc
    	```

## Windows
1. Télécharger et installer[Docker Desktop pour Windows](https://www.docker.com/products/docker-desktop/) (L'installation doit se faire en tant qu'administrateur)
2. Ajouter votre utilisateur windows Groupe docker-users
	- Voir video short : ![capture_docker-users](medias/capture_docker-users.gif)


# Installation
- cd ~ && git clone git@bitbucket.org:dixital-fr/dockernegocianplateform.git && cd dockernegocianplateform && ./install.sh

# Configuration
- Modification des paramétrage DNS windows sur votre connexion réseau (Wifi ou Etherner)
- voir video short ![capture_dns_windows](medias/capture_dns_windows.gif) 

# Utilisation

- Le projet install un lanceur/wrapper : "rundocker"  permettant de simplifié l'utilisation des conteneurs, executé rundocker pour l'aide.

