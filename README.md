# 🎵 Boutique E-commerce de Vinyles

Bienvenue sur notre boutique en ligne de vinyles ! Ce projet vous permet de découvrir des vinyles en promotion, d'ajouter des produits à votre panier et de naviguer sur la boutique. Suivez les étapes ci-dessous pour installer et lancer le projet.

---

## 📌 Installation et Configuration

### 1️⃣ **Placer le projet dans `htdocs`**

Tout d'abord, veuillez placer le projet dans le répertoire `htdocs` de votre installation XAMPP :  
C:\xampp\htdocs\ecommerce

markdown
Copier
Modifier

### 2️⃣ **Démarrer les serveurs Apache et MySQL**

- Ouvrez **XAMPP Control Panel**.
- Cliquez sur **Start** pour **Apache** et **MySQL**.

### 3️⃣ **Créer la base de données**

Pour créer la base de données nécessaire au projet, ouvrez votre navigateur et entrez l'URL suivante :  
🔗 [http://localhost/ecommerce/database/install.php](http://localhost/ecommerce/database/install.php)

Ce script créera automatiquement la base de données **`ecommerce`** et toutes les tables requises.

---

## 📌 Scraping des Produits

Les données des produits proviennent du site **Vinyl Collector**. Pour récupérer ces produits et les insérer dans la base de données, suivez ces étapes :

1. **Ouvrez le terminal (ou l’invite de commandes)**.
2. **Naviguez jusqu’au dossier du projet** :
   ```bash
   cd C:\xampp\htdocs\ecommerce
   Exécutez le script scraper.php pour récupérer les produits :
   bash
   Copier
   Modifier
   php database/scraper.php
   Une fois cette commande exécutée, les produits seront ajoutés automatiquement à la base de données.
   ```

📌 Accéder à la Boutique
Après avoir installé la base de données et exécuté le scraper, vous pouvez accéder à la boutique en ligne en ouvrant votre navigateur et en visitant :
🔗 http://localhost/ecommerce/index.php

📌 Fonctionnalités Principales
✅ Affichage des produits : Consultez les vinyles disponibles.
✅ Détails des produits : Visualisez la description, le prix et l'image de chaque vinyle.
✅ Ajout au panier : Sélectionnez des produits et ajoutez-les à votre panier.
✅ Gestion des utilisateurs : Connexion et gestion des comptes clients et administrateurs.

🚀 Résumé des Étapes d'Installation
1️⃣ Placer le projet dans htdocs.
2️⃣ Démarrer Apache et MySQL via XAMPP.
3️⃣ Créer la base de données via install.php.
4️⃣ Lancer le scraping des produits via php scraper.php.
5️⃣ Accéder à la boutique via index.php.

### **📌 Instructions :**

1. **Crée un fichier `README.md`** à la racine de ton projet.
2. **Colle le contenu ci-dessus dans le fichier**.
3. **Les utilisateurs pourront suivre ces étapes pour installer et lancer le projet**.

✅ **Ce fichier est maintenant prêt à être utilisé** ! Dis-moi si tu veux d'autres modifications. 🚀😃
