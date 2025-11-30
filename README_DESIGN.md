# Health & Fitness - Refonte Design Gymlife

## 📋 Vue d'ensemble

Ce projet a été complètement refondu en s'inspirant du thème **Gymlife** de Colorlib. Le design adopte une approche moderne et premium avec une palette de couleurs sombre (noir) et un accent orange vif (#FF6600).

## 🎨 Caractéristiques du Design

### Palette de Couleurs
- **Fond Principal** : Noir (#000000)
- **Cartes** : Gris très foncé (#1a1a1a à #222222)
- **Texte Principal** : Gris clair (#e5e7eb)
- **Texte Secondaire** : Gris moyen (#94a3b8)
- **Accent Primaire** : Orange vif (#ff6600)
- **Accent Secondaire** : Orange clair (#ff9933)

### Typographie
- **Police Principale** : System UI, Segoe UI, Roboto, sans-serif
- **Titres** : Gras, grande taille, lettres espacées
- **Texte du Corps** : Lisible, sans-serif

### Composants Clés
- **Header** : Navigation sticky avec logo, recherche et menu utilisateur
- **Navigation** : Menu horizontal avec liens actifs soulignés en orange
- **Boutons** : Styles primaire (orange) et outline (transparent avec bordure orange)
- **Cartes** : Avec bordures subtiles et effet hover avec ombre orange
- **Footer** : Contenu riche avec liens rapides, services et contact

## 📁 Structure des Fichiers Modifiés

```
health_fitness/
├── assets/
│   ├── styles/
│   │   └── app.scss          # Styles personnalisés Gymlife
│   ├── images/               # Images de haute qualité
│   └── app.js
├── templates/
│   ├── base.html.twig        # Template de base refondé
│   ├── base_client.html.twig # Template client (existant)
│   ├── home/
│   │   └── index.html.twig   # Page d'accueil refondée
│   ├── coach_client/
│   ├── product_client/
│   ├── service/
│   └── ... (autres templates)
└── webpack.config.js         # Configuration webpack avec SASS activé
```

## 🚀 Installation et Déploiement

### Prérequis
- PHP 8.0+
- Node.js 14+
- Composer
- npm ou yarn

### Étapes d'Installation

1. **Installer les dépendances PHP**
   ```bash
   cd health_fitness
   composer install
   ```

2. **Installer les dépendances Node.js**
   ```bash
   npm install
   ```

3. **Compiler les assets**
   ```bash
   npm run build
   ```

4. **Configuration de la base de données**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Lancer le serveur de développement**
   ```bash
   symfony server:start
   ```

## 📝 Modifications Principales

### 1. Header et Navigation
- Logo redessiné avec accent orange
- Barre de recherche intégrée
- Menu utilisateur avec actions rapides
- Navigation sticky avec indicateurs actifs

### 2. Page d'Accueil
- Hero section avec gradient et texte accrocheur
- Section "Pourquoi nous choisir" avec 4 cartes de fonctionnalités
- Section Services avec 3 services principaux
- Galerie de coachs
- Section Tarification avec 3 plans
- CTA (Call-to-Action) pour inscription

### 3. Styles Globaux
- Gradient de fond subtil
- Transitions et animations fluides
- Responsive design pour tous les appareils
- Accessibilité améliorée

### 4. Composants Réutilisables
- Classe `.hf-btn` pour les boutons
- Classe `.hf-card` pour les cartes
- Classe `.hf-section-title` pour les titres de section
- Variables CSS pour les couleurs et espacements

## 🎯 Améliorations Futures

1. **Animations** : Ajouter des animations au scroll avec AOS.js
2. **Formulaires** : Redesigner tous les formulaires (login, register, etc.)
3. **Pages Intérieures** : Appliquer le design à toutes les pages (services, coachs, produits)
4. **Galerie** : Ajouter une galerie d'images pour les services et coachs
5. **Testimonials** : Section avec avis clients
6. **Blog** : Section blog avec articles de fitness

## 📱 Responsive Design

Le design est entièrement responsive et s'adapte à :
- Desktops (1200px+)
- Tablettes (768px - 1199px)
- Mobiles (< 768px)

## 🔧 Personnalisation

### Modifier les Couleurs
Éditez les variables CSS dans `assets/styles/app.scss` :
```scss
:root {
  --hf-accent: #ff6600;  /* Couleur d'accent primaire */
  --hf-bg: #000000;      /* Couleur de fond */
  /* ... autres variables */
}
```

### Modifier les Polices
Changez la famille de polices dans `assets/styles/app.scss` :
```scss
body {
  font-family: 'Votre Police', sans-serif;
}
```

## 📞 Support

Pour toute question ou suggestion, veuillez contacter l'équipe de développement.

---

**Dernière mise à jour** : 30 Novembre 2025
**Version** : 1.0
**Inspiré par** : Gymlife Theme - Colorlib
