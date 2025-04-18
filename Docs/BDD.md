## 🚀 Setup du projet Symfony - LSI-BD

### 📦 Prérequis

- PHP >= 8.1
- Composer
- MySQL (installé localement, ou via WSL)
- Symfony CLI (optionnelle mais recommandée)
- Apache2 (si vous voulez utiliser phpMyAdmin)

---

### 🔧 1. Cloner le projet

```bash
git clone <url-du-repo>
cd LSI-BD-Projet
composer install
```

### 🛠️ 2. Créer et configurer la base de données
Connectez-vous à MySQL (par exemple en WSL) :

```bash
sudo service mysql start
mysql -u root -p
```

Puis exécutez ces commandes SQL :

```sql
CREATE DATABASE symfony_lsibd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'symfony'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON symfony_lsibd.* TO 'symfony'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Ensuite, configurez votre fichier .env :

```env
DATABASE_URL="mysql://symfony:password@127.0.0.1:3306/symfony_lsibd"
```

### 🧱 3. Générer le schéma et remplir la base

```bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
### 🌐 4. Lancer le projet Symfony

```bash
symfony serve
```

Accédez ensuite à :
👉 http://localhost:8000

🧪 5. Accéder à phpMyAdmin (facultatif)

Installation (si ce n’est pas déjà fait)

```bash
sudo apt install phpmyadmin
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo a2enconf phpmyadmin
sudo systemctl restart apache2
```

Puis accédez à :
👉 http://localhost/phpmyadmin

Identifiants :

Utilisateur : symfony
Mot de passe : password