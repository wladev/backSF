# 🧩 Start-Zup — Back-end Symfony

Back-end complet de l’application Start-Zup, développé avec **Symfony**.

Ce projet a pour but de fournir une **API REST sécurisée**, ainsi qu’un **back-office administrable**, à destination d’un site vitrine React (voir [`start-zup-front`](https://github.com/wladev/wladev-startzup)).

---

## ⚙️ Stack & outils

- **Symfony 6**
- **Doctrine**
- **VichUploaderBundle** pour la gestion des fichiers/images
- **JWT** ou session classique pour l'authentification (à préciser)
- **API Platform** ou contrôleurs personnalisés (à préciser)
- **Twig** pour le rendu du back-office

---

## 🔐 Authentification & rôles

- Inscription avec envoi de mail à l’administrateur
- Validation manuelle des comptes
- Gestion fine des rôles :
  - Accès ou non au back-office
  - Permissions différenciées : création, édition, suppression d’articles, événements, utilisateurs

---

## 🗂 Fonctionnalités back-office

- **Gestion des demandes de contact** (CRUD)
- **Articles de presse** (CRUD avec image)
- **Événements** :
  - Liste à venir / passés / rencontres spécifiques
  - Ajout d’images, modification de dates, etc.
- **Utilisateurs** :
  - Gestion des accès et des rôles
  - Ajout, modification, suppression

---

## 🔌 API exposée

- Endpoints sécurisés pour tous les contenus affichés dans le front-end React
- Routes REST pour événements, articles, utilisateurs, contacts, etc.

---

## 📅 Réalisé en

2024 — Projet de stage de fin d’études (côté back-end)

