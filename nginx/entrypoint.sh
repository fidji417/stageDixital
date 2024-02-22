#!/bin/sh

# Fonction pour renouveler le certificat Let's Encrypt
renew_certificates() {
    certbot renew
}

# Fonction pour obtenir un nouveau certificat Let's Encrypt
get_new_certificate() {
    certbot --nginx -d vps-ea51236b.vps.ovh.net --non-interactive --agree-tos -m floriandarricaud.pro@gmail.com  --redirect --keep-until-expiring
}

# Lancer Nginx en arrière-plan
nginx -g 'daemon off;' &

# Attendre que Nginx démarre
sleep 5

# Vérifier si des certificats existent
if [ -d "/etc/letsencrypt/live/votre-domaine.com" ]; then
    echo "Renouvellement des certificats existants."
    renew_certificates
else
    echo "Obtention d'un nouveau certificat."
    get_new_certificate
fi

# Lancer Nginx en premier plan
nginx -g 'daemon off;'

