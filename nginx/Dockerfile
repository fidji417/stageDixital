# Utiliser l'image NGINX officielle comme base
FROM nginx:latest

# Ajouter l'alias ll
RUN echo "alias ll='ls -l'" >> /root/.bashrc

# Installer les dépendances nécessaires pour ajouter le référentiel NodeSource et autres outils nécessaires
RUN apt-get update && \
    apt-get install -y --no-install-recommends gnupg curl ca-certificates \
    build-essential libtool autoconf automake libpcre3 libpcre3-dev libssl-dev \
    git wget python3-pip
# Télécharger, compiler et installer le connecteur ModSecurity-nginx
RUN git clone --depth 1 https://github.com/SpiderLabs/ModSecurity-nginx.git

# Ajouter le référentiel NodeSource pour installer Node.js et npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -

# Installer Node.js et npm
RUN apt-get update && \
    apt-get install -y nodejs

# Nettoyer le cache APT pour réduire la taille de l'image
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Installer nvm et Node.js via nvm (exemple)
SHELL ["/bin/bash", "-c"]
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash && \
    source ~/.bashrc && \
    nvm install v10.24.1 && \
    nvm use v10.24.1

# Restaurer le SHELL à /bin/sh pour les commandes suivantes
SHELL ["/bin/sh", "-c"]

# Installer ModSecurity
#RUN git clone --depth 1 -b v3/master --single-branch https://github.com/SpiderLabs/ModSecurity.git /usr/local/src/modsecurity && \
#    cd /usr/local/src/modsecurity && \
#    git submodule init && \
#    git submodule update && \
#    ./build.sh && \
#    ./configure && \
#    make && \
#    make install
# Télécharger et compiler Nginx avec le support ModSecurity
#RUN wget http://nginx.org/download/nginx-1.25.3.tar.gz && \
#    tar zxvf nginx-1.25.3.tar.gz && \
#    cd nginx-1.25.3 && \
#    ./configure --with-compat --add-dynamic-module=../ModSecurity-nginx && \
#    make modules && \
#    cp objs/ngx_http_modsecurity_module.so /usr/lib/nginx/modules/

# Copier la configuration de base de ModSecurity
#RUN cp /usr/local/src/modsecurity/modsecurity.conf-recommended /etc/nginx/modsecurity.conf && \
#    sed -i 's/SecRuleEngine DetectionOnly/SecRuleEngine On/' /etc/nginx/modsecurity.conf

# Copier les règles de l'OWASP CRS
#RUN git clone --depth 1 https://github.com/coreruleset/coreruleset /usr/local/src/coreruleset && \
#    cp -R /usr/local/src/coreruleset/rules /etc/nginx/owasp-crs && \
#    echo "Include owasp-crs/crs-setup.conf" >> /etc/nginx/modsecurity.conf && \
#    echo "Include owasp-crs/rules/*.conf" >> /etc/nginx/modsecurity.conf

# Installer Certbot
# RUN pip3 install certbot certbot-nginx

# Copier la configuration de Nginx (assurez-vous d'avoir un fichier nginx.conf approprié)
COPY nginx.conf /etc/nginx/nginx.conf

# Exposer les ports
EXPOSE 80
EXPOSE 443

# CMD
CMD ["nginx", "-g", "daemon off;"]

