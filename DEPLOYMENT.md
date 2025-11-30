# 🚀 GUIDE DE DÉPLOIEMENT - Portfolio Cybersécurité

## Table des matières
1. [Déploiement Local](#déploiement-local)
2. [Déploiement sur Hébergement Web](#déploiement-sur-hébergement-web)
3. [Déploiement avec Docker](#déploiement-avec-docker)
4. [Configuration du Domaine](#configuration-du-domaine)
5. [Post-Déploiement](#post-déploiement)

---

## Déploiement Local

### Prérequis
- PHP 7.4+ installé
- Serveur web (Apache, Nginx, ou serveur PHP intégré)
- Git (optionnel)

### Installation

#### Option 1 : Serveur PHP intégré
```bash
cd portfolio
php -S localhost:8000
```
Accédez à http://localhost:8000

#### Option 2 : Apache avec XAMPP/WAMP
```bash
# Placer dans htdocs (XAMPP) ou www (WAMP)
C:\xampp\htdocs\portfolio
D:\wamp\www\portfolio
```
Accédez à http://localhost/portfolio

#### Option 3 : Nginx
```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/portfolio;
    
    index index.html index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

---

## Déploiement sur Hébergement Web

### Préparation des fichiers

1. **Télécharger tous les fichiers**
```bash
git clone https://votre-repo.git
# ou télécharger le ZIP
```

2. **Créer les dossiers manquants**
```bash
mkdir logs
mkdir uploads
chmod 755 logs uploads
```

3. **Configurer send_email.php**
Modifier la ligne:
```php
$to = 'votre-email@exemple.com';
```

### Hébergement cPanel

1. **Accéder à cPanel**
   - Aller sur cpanel.votredomaine.com
   - Se connecter avec identifiants

2. **Télécharger via File Manager**
   - Cliquer sur "File Manager"
   - Naviguer vers public_html
   - Créer dossier "portfolio"
   - Uploader tous les fichiers

3. **Ou utiliser FTP**
```bash
ftp ftp.votredomaine.com
# Identifiants: nom d'utilisateur et mot de passe FTP
# Uploader tous les fichiers
```

4. **Vérifier PHP est activé**
   - Dans cPanel: "Select PHP Version"
   - S'assurer que PHP 7.4+ est sélectionné

5. **Accéder au site**
   - http://votredomaine.com/portfolio
   - http://www.votredomaine.com/portfolio

### Heroku (Frontend only - sans formulaire)

```bash
# Installer Heroku CLI
npm install -g heroku

# Créer app
heroku create nom-app

# Déployer
git push heroku main

# Ouvrir
heroku open
```

### Vercel

```bash
# Installer Vercel CLI
npm i -g vercel

# Déployer
vercel

# Options: Production
```

### Netlify

1. Aller sur netlify.com
2. "New site from Git"
3. Sélectionner repository
4. Build command: (laisser vide)
5. Publish directory: .
6. Deploy

---

## Déploiement avec Docker

### Prérequis
- Docker installé
- Docker Compose installé

### Installation

```bash
# Naviguer dans le dossier
cd portfolio

# Construire l'image
docker build -t portfolio .

# Lancer avec Docker Compose
docker-compose up -d

# Arrêter
docker-compose down
```

Accédez à http://localhost

### Déploiement sur DigitalOcean avec Docker

```bash
# Via SSH
ssh root@votre-ip

# Installer Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# Cloner le repo
git clone https://votre-repo.git
cd portfolio

# Lancer
docker-compose up -d

# Accédez via IP de DigitalOcean
```

---

## Configuration du Domaine

### Acheter un domaine
- Registrar populaire: Namecheap, GoDaddy, OVH

### Configurer DNS

#### Avec hébergement partagé (cPanel)
1. Dans le registrar:
   - Changer les nameservers vers ceux du fournisseur
2. Dans cPanel:
   - "Addon Domains"
   - Ajouter votre domaine

#### Avec DigitalOcean
```bash
# Ajouter DNS
# A record: votredomaine.com -> votre-ip
# A record: www.votredomaine.com -> votre-ip
# CNAME: www -> votredomaine.com (optionnel)
```

### HTTPS (SSL Certificate)

#### cPanel (Gratuit Let's Encrypt)
1. "AutoSSL"
2. Installer certificate
3. Accès automatique à https://

#### Manuel avec certbot
```bash
sudo apt install certbot python3-certbot-apache
sudo certbot certonly --apache -d votredomaine.com
```

---

## Post-Déploiement

### Checklist finale

- [ ] Site accessible via domaine
- [ ] HTTPS activé
- [ ] Formulaire de contact fonctionne
- [ ] Images chargées correctement
- [ ] CSS/JS chargés correctement
- [ ] Responsive design testé (mobile/tablette)
- [ ] Tous les liens fonctionnent
- [ ] Email de configuration correct
- [ ] Analytics configuré (optionnel)

### Optimisation Performance

#### Caching
```bash
# Dans .htaccess (déjà fourni)
# Caching automatique des assets
```

#### Minification
```bash
npm run build
# Génère styles.min.css et script.min.js
# Modifier index.html pour les utiliser
```

#### Compression Gzip
```bash
# Dans .htaccess (déjà fourni)
# Apache comprime automatiquement
```

#### CDN (optionnel)
- Ajouter Cloudflare
- Configuration SSL/TLS: Full
- Purger cache si modifications

### Monitoring

#### Google Analytics
1. Aller sur analytics.google.com
2. Créer propriété
3. Copier ID (UA-XXXXXXXXX-X)
4. Dans index.html: Ajouter script Google Analytics
5. Attendre 24h pour données

#### Uptime Monitoring
- Utiliser UptimeRobot.com (gratuit)
- Configurer alertes email

### Sauvegarde

```bash
# Sauvegarder régulièrement
# Via FTP ou cPanel Backup

# Via command line
tar -czf portfolio_backup.tar.gz portfolio/
```

---

## Troubleshooting

### Le site ne charge pas
- Vérifier les permissions des fichiers (755)
- Vérifier la configuration DNS
- Vérifier les logs du serveur

### Formulaire ne fonctionne pas
- Vérifier PHP est activé
- Vérifier permissions send_email.php
- Vérifier email dans config

### Les styles ne chargent pas
- Vérifier chemin CSS
- Vérifier permissions fichiers
- Vider le cache navigateur (Ctrl+Shift+Del)

### Problèmes de performance
- Compresser les images
- Minifier CSS/JS
- Activer caching
- Utiliser CDN

---

## Support & Aide

- Documentation: README.md
- Email: abdoulahim10@gmail.com
- Téléphone: +221 77 382 33 07

---

**Portfolio prêt pour production! 🎯**
