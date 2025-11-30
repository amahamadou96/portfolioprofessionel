# 🎨 GUIDE DE PERSONNALISATION RAPIDE

## Modification des informations personnelles

### 1. Changer le nom et le titre

**Fichier:** `index.html`

Ligne 83-85:
```html
<h1 class="hero-title">Abdoulahi Mahamadou Soumaila</h1>
<p class="hero-subtitle">Étudiant en Cybersécurité</p>
<p class="hero-description">
    Spécialisé en analyse de cybersécurité et sécurité des réseaux.
</p>
```

Changez pour votre nom et description.

### 2. Modifier les coordonnées

**Fichier:** `index.html`

Ligne 94-108:
```html
<div class="info-item">
    <span class="info-label">Email:</span>
    <a href="mailto:abdoulahim10@gmail.com">abdoulahim10@gmail.com</a>
</div>
<div class="info-item">
    <span class="info-label">Téléphone:</span>
    <a href="tel:+221773823307">+221 77 382 33 07</a>
</div>
```

Changez l'email et le téléphone.

### 3. Mettre à jour les liens de contact

**Fichier:** `index.html`

Ligne 88-92 (Hero section):
```html
<a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">
    <i class="fab fa-linkedin"></i>
</a>
```

Remplacez par vos vrais liens:
```html
<a href="https://linkedin.com/in/votre-profil" target="_blank">
```

---

## Modification des couleurs

**Fichier:** `styles.css`

Ligne 1-15 (Variables CSS):
```css
:root {
    --primary-color: #0f3460;
    --secondary-color: #16213e;
    --accent-color: #00d4ff;
    --accent-hover: #00a8cc;
    ...
}
```

**Exemples de palettes alternatives:**

**Palette rouge (Sécurité aggressive):**
```css
--primary-color: #1a0000;
--accent-color: #ff0000;
--accent-hover: #cc0000;
```

**Palette verte (Sécurité positive):**
```css
--primary-color: #0a1f00;
--accent-color: #00ff00;
--accent-hover: #00cc00;
```

**Palette orange (Sécurité alerte):**
```css
--primary-color: #1f0f00;
--accent-color: #ff8800;
--accent-hover: #cc6600;
```

---

## Modification des projets

**Fichier:** `script.js`

Ligne 238-306 (projectsData):

```javascript
const projectsData = {
    1: {
        title: 'ARADASCHOOL',
        description: 'Plateforme éducative innovante',
        details: `
            <h2>ARADASCHOOL - Plateforme Éducative</h2>
            <p><strong>Description:</strong> ...</p>
            ...
        `
    },
    2: {
        title: 'CYBER GARE 4 ALL',
        description: 'Initiative de sensibilisation',
        details: `...`
    }
};
```

**Pour ajouter un 3e projet:**

1. Dupliquer le bloc du projet 1 ou 2
2. Changer l'ID (3)
3. Modifier le titre et la description
4. Ajouter une carte dans `index.html` (ligne 270-285)

```html
<div class="project-card" data-project="3">
    <div class="project-image">
        <i class="fas fa-rocket"></i>
    </div>
    <div class="project-content">
        <h3>Votre Projet</h3>
        <p class="project-description">Description</p>
        <div class="project-tags">
            <span class="tag">Tag1</span>
            <span class="tag">Tag2</span>
        </div>
        <button class="btn-details" onclick="openProjectModal(3)">
            Voir détails
        </button>
    </div>
</div>
```

---

## Modification des compétences

**Fichier:** `index.html`

Ligne 141-196 (Skills section):

**Pour modifier une barre de progression:**
```html
<div class="skill-item">
    <div class="skill-header">
        <span>Analyse de Sécurité</span>
        <span class="skill-level">90%</span>
    </div>
    <div class="skill-bar">
        <div class="skill-progress" style="width: 90%"></div>
    </div>
</div>
```

Changez le texte et le pourcentage.

**Pour ajouter un badge:**
```html
<span class="badge">Votre compétence</span>
```

---

## Modification des formations

**Fichier:** `index.html`

Ligne 385-422 (Certifications section):

**Pour ajouter une formation:**
```html
<div class="cert-card">
    <i class="fas fa-certificate"></i>
    <h3>Votre Plateforme</h3>
    <p>Description de la formation</p>
</div>
```

---

## Configuration de l'email

**Fichier:** `send_email.php`

Ligne 55:
```php
$to = 'abdoulahim10@gmail.com';
```

Changez pour votre email.

**Fichier:** `config.php`

Ligne 14-16:
```php
define('CONTACT_EMAIL', 'abdoulahim10@gmail.com');
define('CONTACT_PHONE', '+221 77 382 33 07');
```

---

## Modification du texte "À propos"

**Fichier:** `index.html`

Ligne 124-135 (About section):

```html
<p>
    Je suis un étudiant passionné en cybersécurité...
</p>
<p>
    Mes études et formations pratiques...
</p>
<p>
    En dehors des études...
</p>
```

Remplacez par votre biographie personnelle.

---

## Changement des icônes

Cherchez les icônes Font Awesome sur: https://fontawesome.com/icons

Remplacez par exemple:
```html
<!-- De -->
<i class="fas fa-graduation-cap"></i>

<!-- À -->
<i class="fas fa-laptop-code"></i>
```

**Icônes cybersécurité populaires:**
```
fas fa-shield-alt     - Bouclier
fas fa-lock           - Cadenas
fas fa-key            - Clé
fas fa-user-secret    - Agent secret
fas fa-network-wired  - Réseau
fas fa-bug            - Bug
fas fa-tools          - Outils
fas fa-server         - Serveur
fas fa-database       - Base de données
fas fa-code           - Code
```

---

## Modification des animations

**Fichier:** `styles.css`

Les animations sont dans les sections avec `@keyframes`.

**Pour ralentir une animation:**
```css
animation: fadeInUp 0.6s ease-out; /* 0.6s = durée */
```

Augmentez la valeur pour plus lent.

**Pour changer le type d'animation:**
```css
ease-out          - Commence rapide, finit lent
ease-in           - Commence lent, finit rapide
ease-in-out       - Lent, rapide, lent
linear            - Vitesse constante
```

---

## Modification du contenu du footer

**Fichier:** `index.html`

Ligne 432-466 (Footer section):

```html
<a href="https://linkedin.com" target="_blank">
    <i class="fab fa-linkedin"></i>
</a>
```

Changez les URLs de vos réseaux sociaux.

---

## Modification du formulaire de contact

**Fichier:** `index.html`

Ligne 404-427 (Contact form):

Pour ajouter un champ:
```html
<div class="form-group">
    <input type="text" placeholder="Sujet" required>
</div>
```

**Mise à jour du PHP:**

Ajoutez dans `send_email.php`:
```php
$subject_input = isset($_POST['subject']) ? sanitizeInput($_POST['subject']) : '';
```

---

## Responsive Design - Ajustements

**Fichier:** `styles.css`

Ligne 750+ (Media queries):

```css
@media (max-width: 768px) {
    /* Modifications pour tablette */
}

@media (max-width: 480px) {
    /* Modifications pour mobile */
}
```

**Pour changer la breakpoint:**
```css
@media (max-width: 900px) {
    /* Nouveau point d'arrêt */
}
```

---

## Ajout d'une image de profil

**Fichier:** `index.html`

Dans la section Hero (ligne 80-82):

```html
<div class="hero-animation">
    <img src="votre-photo.jpg" alt="Photo de profil" class="profile-pic">
</div>
```

**Fichier:** `styles.css`

Ajoutez:
```css
.profile-pic {
    width: 300px;
    height: 300px;
    border-radius: 50%;
    border: 3px solid var(--accent-color);
    object-fit: cover;
    animation: fadeInRight 1s ease-out;
}
```

---

## SEO - Modification des meta tags

**Fichier:** `index.html`

Ligne 6-12:
```html
<meta name="description" content="Votre description">
<meta name="keywords" content="vos, mots, clés">
<meta name="author" content="Votre Nom">
<meta property="og:title" content="Votre Titre">
<meta property="og:description" content="Votre Description">
```

---

## Google Analytics

**Fichier:** `index.html`

Avant `</body>` (ligne 540):

```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-XXXXXXXXX-X');
</script>
```

Remplacez `UA-XXXXXXXXX-X` par votre ID Google Analytics.

---

## Police de caractères personnalisée

**Fichier:** `styles.css`

Ligne 30 (body):

```css
font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
```

**Alternatives populaires:**
```
'Arial', sans-serif
'Courier New', monospace
'Georgia', serif
'Trebuchet MS', sans-serif
'Comic Sans MS', cursive
```

**Avec Google Fonts:**

Ajoutez dans `<head>`:
```html
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
```

Puis changez la police:
```css
font-family: 'Poppins', sans-serif;
```

---

## Tests après modifications

1. Ouvrir `test.html` pour vérifier
2. Tester sur mobile (F12 > Toggle device toolbar)
3. Vérifier les liens sont corrects
4. Tester le formulaire
5. Vérifier les animations

---

## Besoin d'aide?

📧 Email: abdoulahim10@gmail.com
📱 Téléphone: +221 77 382 33 07

---

**Bon courage pour personnaliser votre portfolio! 🚀**
