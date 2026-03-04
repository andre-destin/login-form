# Système d'authentification — Login Form

## Contexte du projet

Dans le cadre d'un module suivi en classe, j'ai eu à concevoir et développer un système d'authentification complet. L'objectif principal était de mettre en place un formulaire de connexion fonctionnel et sécurisé, permettant à un utilisateur de s'inscrire, de se connecter, et d'accéder à un espace qui lui est réservé.

Ce projet m'a permis de mobiliser plusieurs compétences techniques acquises tout au long du module, notamment en ce qui concerne la gestion des formulaires, la communication avec une base de données, et surtout la sécurisation des échanges de données.

---

## Ce que j'ai réalisé

J'ai développé un système d'authentification qui comprend :

- Un formulaire d'inscription permettant à un nouvel utilisateur de créer un compte
- Un formulaire de connexion avec vérification des identifiants
- Une gestion des sessions pour maintenir l'utilisateur connecté
- Une redirection vers une page protégée après connexion réussie
- Des messages d'erreur clairs en cas d'identifiants incorrects

---

## Techniques et outils utilisés

Pour mener à bien ce projet, j'ai utilisé plusieurs technologies et approches que je détaille ci-dessous.

### Front-end

Du côté de l'interface, j'ai conçu les formulaires en HTML et CSS afin de proposer une expérience utilisateur simple et claire. J'ai veillé à ce que les champs soient bien structurés et que les retours visuels soient compréhensibles pour l'utilisateur.

### Back-end

Côté serveur, j'ai géré la logique d'authentification en PHP. C'est le serveur qui reçoit les données du formulaire, les vérifie, et décide si l'utilisateur est autorisé à accéder à l'application ou non.

### Base de données

J'ai utilisé une base de données relationnelle pour stocker les informations des utilisateurs, notamment leurs identifiants et leurs mots de passe. Les mots de passe ne sont pas stockés en clair : je les ai hashés avant de les enregistrer, ce qui constitue une bonne pratique essentielle en matière de sécurité.

---

## Les requêtes préparées : un choix de sécurité essentiel

L'un des points sur lesquels j'ai particulièrement porté attention, c'est la sécurisation des interactions avec la base de données. Pour cela, j'ai utilisé des **requêtes préparées**.

Une requête préparée est une façon d'écrire les requêtes SQL de manière à séparer clairement la structure de la requête des données fournies par l'utilisateur. Concrètement, au lieu d'insérer directement ce que l'utilisateur a tapé dans le formulaire à l'intérieur de la requête SQL, on définit d'abord la structure de la requête avec des paramètres, puis on y associe les données séparément.

J'ai fait ce choix délibérément pour me protéger contre les **injections SQL**. Une injection SQL est une attaque courante dans laquelle un utilisateur malveillant insère du code SQL dans un champ de formulaire pour manipuler la base de données, accéder à des données sensibles, ou même supprimer des tables entières. En utilisant des requêtes préparées, les données saisies par l'utilisateur sont automatiquement traitées comme de simples valeurs et non comme du code SQL exécutable, ce qui neutralise complètement ce type d'attaque.

C'est une protection simple à mettre en place mais qui fait une énorme différence en termes de sécurité, et c'est pourquoi j'ai tenu à l'intégrer dès le départ dans mon projet.

---

## Ce que ce projet m'a apporté

Ce projet m'a permis de comprendre concrètement comment fonctionne un système d'authentification de bout en bout, de la saisie des données par l'utilisateur jusqu'à leur vérification sécurisée côté serveur. J'ai également pris conscience de l'importance de ne jamais faire confiance aux données provenant de l'utilisateur, et de toujours les traiter avec rigueur avant de les utiliser dans une requête ou de les stocker en base de données.

C'est un projet qui m'a beaucoup appris, autant sur le plan technique que sur les bonnes pratiques de développement web sécurisé.
