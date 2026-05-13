# Claude Symfony Template

Template Claude Code pour projets Symfony.

Ce dépôt contient une configuration `.claude/` complète mais modulaire, pensée pour être copiée dans chaque nouveau projet Symfony, puis adaptée au contexte réel du projet.

L'objectif est d'aider Claude Code à :

- coder plus vite ;
- éviter les bugs ;
- respecter l'architecture du projet ;
- améliorer la lisibilité et la maintenabilité ;
- faire des reviews utiles ;
- sécuriser le code ;
- écrire ou mettre à jour les tests ;
- préparer les déploiements sans exécuter d'actions dangereuses automatiquement.

Ce template est volontairement générique. Il ne contient pas de secrets, pas de configuration personnelle, et peut être publié ou partagé.

---

## Principe général

Ce repo n'est pas un projet Symfony.

C'est un template à copier dans un projet existant ou nouveau.

Structure principale :

```text
.
├── CLAUDE.md
├── .mcp.json
├── .claude/
│   ├── project-profile.md
│   ├── settings.json
│   ├── settings.local.example.json
│   ├── rules/
│   ├── skills/
│   ├── agents/
│   ├── commands/
│   ├── design/
│   └── _templates/
│       └── hooks/
└── README.md
```

---

## Rôle des fichiers

### `CLAUDE.md`

Fichier principal de contexte du projet.

Il doit rester court et contenir :

- le résumé du projet ;
- les objectifs de Claude ;
- les règles principales ;
- les fichiers importants à consulter ;
- les zones sensibles.

Il ne doit pas contenir tes préférences personnelles.  
Les préférences personnelles doivent rester dans ta configuration locale Claude.

**Budget token à respecter :** `CLAUDE.md` est chargé au démarrage de chaque session et reste en contexte du début à la fin. Son coût est fixe par session, quelle que soit sa longueur. Vise 300 à 600 tokens (environ 50 à 100 lignes). Au-delà de 2 000 tokens, le suivi des instructions se dégrade et la fenêtre de contexte utile se réduit. Si ton fichier grossit, déplace le contenu dans `.claude/rules/` ou `.claude/project-profile.md`.

Pour les projets avec plusieurs modules distincts (monorepo, microservices), tu peux placer un `CLAUDE.md` dans chaque sous-dossier. Claude le charge automatiquement quand il navigue dans ce dossier. Cela évite un seul fichier racine trop volumineux.

---

### `.claude/project-profile.md`

Fichier à adapter pour chaque projet.

Il décrit :

- le nom du projet ;
- le type de projet ;
- la stack exacte ;
- l'architecture choisie ;
- les commandes locales ;
- la base de données ;
- le déploiement ;
- les zones sensibles.

C'est probablement le fichier le plus important à personnaliser.

---

### `.claude/settings.json`

Configuration partagée de Claude Code.

Elle définit :

- les commandes autorisées ;
- les commandes qui demandent confirmation ;
- les fichiers interdits à la lecture ;
- les commandes dangereuses interdites.

Le fichier est volontairement prudent.

---

### `.claude/settings.local.example.json`

Exemple de configuration locale.

À copier si besoin :

```bash
cp .claude/settings.local.example.json .claude/settings.local.json
```

Le fichier réel `.claude/settings.local.json` ne doit pas être versionné.

---

### `.claude/rules/`

Règles permanentes du projet.

Elles sont courtes et thématiques :

```text
code-style.md
quality.md
anti-overengineering.md
symfony.md
architecture.md
doctrine.md
twig.md
frontend.md
testing.md
security.md
deployment.md
api-platform.md
```

Ces fichiers donnent les conventions générales à Claude.

Certains fichiers de règles utilisent un frontmatter `paths:` pour ne s'activer que lorsque Claude travaille sur des fichiers correspondants :

```markdown
---
paths:
  - "src/Entity/**"
  - "src/Repository/**"
  - "migrations/**"
---
```

Règles avec `paths:` (chargement ciblé) : `doctrine.md`, `twig.md`, `frontend.md`, `api-platform.md`.  
Règles sans `paths:` (toujours chargées) : `code-style.md`, `architecture.md`, `testing.md`, `security.md`, `symfony.md`, `quality.md`.

---

### `.claude/skills/`

Workflows spécialisés.

Chaque skill est un dossier avec un fichier `SKILL.md`.

Exemple :

```text
.claude/skills/review-changes/SKILL.md
.claude/skills/symfony-debug/SKILL.md
.claude/skills/deploy-update-vps/SKILL.md
```

Les skills servent pour des tâches précises :

- review de code ;
- debug Symfony ;
- ajout de tests ;
- sécurité ;
- migration Doctrine ;
- déploiement ;
- création de CRUD ;
- API Platform ;
- frontend Twig/Tailwind ;
- etc.

Certains skills sensibles sont configurés pour être utilisés manuellement uniquement.

---

### `.claude/commands/`

Commandes slash personnalisées.

Chaque fichier dans ce dossier devient une commande invocable avec `/project:nom-commande`.

```text
.claude/commands/fix-issue.md    → /project:fix-issue 42
.claude/commands/review-pr.md   → /project:review-pr
.claude/commands/deploy.md      → /project:deploy install
.claude/commands/grumphp.md     → /project:grumphp
```

Les commandes personnelles placées dans `~/.claude/commands/` sont disponibles dans tous les projets sous la forme `/user:nom-commande`.

La syntaxe `` !`commande shell` `` dans le corps d'une command exécute la commande shell et injecte son résultat directement dans le prompt avant que Claude ne commence à lire :

```markdown
## Diff actuel
!`git diff main...HEAD`

Analyse ces changements...
```

**Différence avec les skills :** un skill s'invoque en langage naturel ("utilise le skill X"). Une command est un raccourci tapable avec des arguments (`/project:fix-issue 42`).

Pour ajouter une commande : créer un fichier `.claude/commands/ma-commande.md` avec le frontmatter suivant :

```markdown
---
name: ma-commande
argument-hint: [argument-optionnel]
---

Instructions que Claude suit quand tu tapes /ma-commande.
$ARGUMENTS est remplacé par ce que tu passes après le nom.
```

---

### `.claude/agents/`

Subagents spécialisés.

Ils servent à déléguer une analyse à un rôle précis :

```text
code-reviewer.md
symfony-architect.md
security-auditor.md
doctrine-specialist.md
test-writer.md
frontend-ui-designer.md
deployment-advisor.md
bug-hunter.md
```

Les agents sont volontairement courts et spécialisés.

---

### Distinction skills / agents

Un **skill** est un workflow que Claude exécute lui-même, dans sa propre session de conversation.  
Un **agent** est un subagent délégué avec un contexte isolé, des outils restreints et un rôle précis.

Utilise un skill quand Claude doit effectuer une tâche directement.  
Utilise un agent quand tu veux déléguer une analyse à un rôle distinct, sans charger la session principale, ou pour obtenir un second avis indépendant.

Les deux peuvent couvrir le même domaine (par exemple la review de code), mais la délégation via agent protège le contexte principal et isole la responsabilité.

---

### `.claude/_templates/architectures/`

Templates d'architecture.

Trois architectures sont prévues :

```text
classic-symfony.md
service-manager.md
ddd-light.md
```

Quand tu démarres un projet, tu choisis l'architecture adaptée, puis tu copies le contenu dans :

```text
.claude/rules/architecture.md
```

---

### `.claude/_templates/hooks/`

Exemples de hooks shell pour automatiser les vérifications qualité.

Les hooks sont des scripts exécutés avant ou après une action de Claude.

```text
_templates/hooks/pre-commit.sh.example   → vérifie PHP, GrumPHP, PHPStan avant commit
_templates/hooks/lint-on-save.sh.example → PHP-CS-Fixer, lint Twig/YAML après édition
```

**Pour activer dans un projet :**

1. Copier et adapter le script dans `.claude/hooks/` :
```bash
cp .claude/_templates/hooks/pre-commit.sh.example .claude/hooks/pre-commit.sh
chmod +x .claude/hooks/pre-commit.sh
```

2. Enregistrer dans `.claude/settings.json` :
```json
"hooks": {
  "PreToolUse": [{
    "matcher": "Bash",
    "hooks": [{ "type": "command", "command": ".claude/hooks/pre-commit.sh" }]
  }],
  "PostToolUse": [{
    "matcher": "Edit|Write",
    "hooks": [{ "type": "command", "command": ".claude/hooks/lint-on-save.sh" }]
  }]
}
```

Exit code `2` = action bloquée. Exit code `0` = action autorisée.

---

### `.claude/_templates/design/`

Contient les templates design.

Le dossier peut contenir le repo `awesome-design-md`, qui propose plusieurs styles visuels sous forme de fichiers `DESIGN.md`.

Le catalogue complet ne doit pas être chargé automatiquement par Claude.

Pour un projet, il faut copier un seul design actif à la racine :

```text
DESIGN.md
```

---

### `.claude/design/design-brief.md`

Fichier spécifique au projet pour préciser le design attendu.

Il peut compléter le `DESIGN.md` actif.

---

### `.mcp.json`

Configuration MCP du projet.

Par défaut, ce template peut utiliser Context7 comme exemple, pour aider Claude à consulter de la documentation à jour sur les dépendances.

---

## Installation dans un nouveau projet

Depuis la racine de ton projet Symfony, copie les fichiers du template.

Exemple :

```bash
cp -R /chemin/vers/claude-symfony-template/.claude .
cp /chemin/vers/claude-symfony-template/CLAUDE.md .
cp /chemin/vers/claude-symfony-template/.mcp.json .
```

Puis ajoute le fichier local Claude au `.gitignore` du projet :

```bash
cat >> .gitignore <<'EOF_GITIGNORE'

# Claude Code local settings
.claude/settings.local.json
EOF_GITIGNORE
```

---

## Adapter le template au projet

### 1. Remplir le profil projet

Copie le template :

```bash
cp .claude/_templates/project-profile.template.md .claude/project-profile.md
```

Puis adapte :

```text
.claude/project-profile.md
```

Tu peux aussi demander à Claude de le faire automatiquement avec le skill `fill-todos`.

```text
Utilise le skill fill-todos.
```

Ce skill inspecte le projet (composer.json, .env, src/, git remote, etc.), auto-remplit tout ce qu'il peut détecter, puis pose uniquement les questions pour ce qui reste inconnu (nom du projet, domaine, déploiement, etc.).

---

### 2. Choisir l'architecture

Choisis une architecture selon le projet.

#### Petit projet, CRUD, site vitrine, prototype

```bash
cp .claude/_templates/architectures/classic-symfony.md .claude/rules/architecture.md
```

#### Projet moyen avec vraie logique métier

```bash
cp .claude/_templates/architectures/service-manager.md .claude/rules/architecture.md
```

#### Gros projet métier, SaaS, réservation, pricing, workspace

```bash
cp .claude/_templates/architectures/ddd-light.md .claude/rules/architecture.md
```

Prompt conseillé :

```text
Analyse ce projet Symfony et aide-moi à choisir l'architecture la plus adaptée parmi :
- classic-symfony ;
- service-manager ;
- ddd-light.

Explique ton choix en fonction :
- de la taille du projet ;
- de la complexité métier ;
- des dossiers existants ;
- des entités ;
- des services ;
- des contrôleurs ;
- des tests ;
- du niveau de maintenabilité souhaité.

Ensuite, mets à jour `.claude/rules/architecture.md` avec le template correspondant.
```

---

### 3. Adapter `CLAUDE.md`

Le fichier `CLAUDE.md` doit rester court.

Prompt conseillé :

```text
Lis `CLAUDE.md` et `.claude/project-profile.md`.

Adapte `CLAUDE.md` à ce projet, mais garde-le court.

Il doit contenir :
- un résumé du projet ;
- les objectifs de Claude ;
- les fichiers importants ;
- les conventions principales ;
- les zones sensibles.

Ne mets pas de préférences personnelles.
Ne duplique pas toutes les règles présentes dans `.claude/rules/`.
```

---

### 4. Choisir un design actif

Le catalogue design se trouve ici :

```text
.claude/_templates/design/awesome-design-md/design-md/
```

Choisis un style, puis copie son `DESIGN.md` à la racine.

Exemple :

```bash
cp .claude/_templates/design/awesome-design-md/design-md/stripe/DESIGN.md DESIGN.md
```

ou :

```bash
cp .claude/_templates/design/awesome-design-md/design-md/claude/DESIGN.md DESIGN.md
```

Le fichier actif du projet doit être :

```text
DESIGN.md
```

Tu peux ensuite adapter :

```text
.claude/design/design-brief.md
```

Prompt conseillé :

```text
Je veux définir le design actif de ce projet.

Regarde les templates disponibles dans `.claude/_templates/design/awesome-design-md/design-md/`.

Propose-moi 5 styles adaptés à ce projet en expliquant rapidement pourquoi.

Ne lis pas tout le catalogue en détail.
Compare seulement les noms, README et intentions générales.

Quand j'aurai choisi, tu copieras le `DESIGN.md` correspondant à la racine du projet.
```

Prompt pour implémenter une page avec le design :

```text
Utilise le skill frontend-page.

Crée ou améliore cette page en respectant :
- `DESIGN.md` ;
- `.claude/design/design-brief.md` ;
- les conventions Twig ;
- Tailwind CSS ;
- Stimulus seulement si utile.

Garde le HTML lisible.
Extrais les blocs réutilisables en partials ou composants Twig.
```

---

## Utilisation quotidienne

### Implémenter une fonctionnalité

```text
Utilise le skill implement-feature.

Implémente cette fonctionnalité : [décrire la fonctionnalité].

Respecte :
- `.claude/project-profile.md` ;
- `.claude/rules/architecture.md` ;
- `.claude/rules/symfony.md` ;
- `.claude/rules/testing.md` ;
- `.claude/rules/security.md`.

Ajoute ou mets à jour les tests nécessaires.
Après l'implémentation, utilise review-changes pour proposer les améliorations éventuelles.
```

---

### Déboguer une erreur Symfony

```text
Utilise le skill symfony-debug.

Voici l'erreur :

[coller l'erreur complète]

Analyse la cause probable.
Inspecte les fichiers nécessaires.
Propose le plus petit correctif fiable.
Indique la commande pour vérifier.
```

---

### Faire une review après modification

```text
Utilise le skill review-changes.

Analyse uniquement les fichiers modifiés.

Vérifie :
- lisibilité ;
- maintenabilité ;
- cohérence avec l'architecture ;
- tests manquants ;
- sécurité ;
- risque de régression ;
- compatibilité GrumPHP.

Ne réécris pas tout.
Propose d'abord les améliorations utiles.
```

---

### Ajouter ou corriger des tests

```text
Utilise le skill test-implementation.

Analyse les changements récents et ajoute les tests nécessaires.

Priorité :
- logique métier ;
- services ;
- handlers ;
- contrôleurs importants ;
- formulaires ;
- voters ;
- API Platform ;
- commandes ;
- emails si le comportement est important.

Utilise PHPUnit.
Garde les tests lisibles et utiles contre les régressions.
```

---

### Vérifier une migration Doctrine

```text
Utilise le skill doctrine-migration-review.

Analyse les entités modifiées et la migration générée.

Vérifie :
- clés étrangères ;
- index ;
- nullable ;
- contraintes uniques ;
- risque de perte de données ;
- compatibilité production ;
- migration destructive.

Ne modifie jamais une ancienne migration déjà jouée.
```

---

### Faire une review sécurité

```text
Utilise le skill security-review.

Analyse les zones sensibles de ce changement.

Vérifie :
- authentification ;
- autorisation ;
- voters ;
- CSRF ;
- XSS ;
- uploads ;
- paiements ;
- webhooks ;
- exposition de données utilisateur ;
- secrets.

Retourne les problèmes par gravité.
Ne modifie pas le code sans me proposer un plan.
```

---

### Préparer une installation VPS

```text
Utilise le skill deploy-install-vps.

Prépare une checklist d'installation initiale pour ce projet Symfony sur VPS Ubuntu.

Contexte :
- Caddy ;
- PHP-FPM ;
- MariaDB/MySQL ;
- GitHub ;
- Composer ;
- éventuellement build frontend.

Utilise les informations de `.claude/project-profile.md`.
Utilise des placeholders pour les secrets.
Ne propose jamais `chmod -R 777`.
```

---

### Préparer une mise à jour VPS

```text
Utilise le skill deploy-update-vps.

Prépare les commandes de mise à jour production pour ce projet.

Workflow attendu :
- git status ;
- git pull ;
- composer install --no-dev --optimize-autoloader ;
- build frontend si nécessaire ;
- doctrine:migrations:status ;
- doctrine:migrations:migrate si nécessaire ;
- cache clear ;
- permissions var/ ;
- vérifications finales.

Ne lance rien sur le serveur.
Donne-moi une checklist claire.
```

---

### Vérifier GrumPHP avant commit

```text
Utilise le skill grumphp-check.

Analyse les fichiers modifiés et vérifie ce qui pourrait faire échouer GrumPHP.

Regarde :
- imports inutiles ;
- debug code ;
- formatage ;
- tests ;
- erreurs PHPStan ou PHP-CS-Fixer si configurés.

Indique la commande à lancer.
Ne fais pas de commit.
```

---

## Agents disponibles

### `code-reviewer`

À utiliser pour une review générale du code.

```text
Demande au subagent code-reviewer de relire les fichiers modifiés et de me faire une review concise.
```

### `symfony-architect`

À utiliser pour vérifier l'organisation du projet.

```text
Demande au subagent symfony-architect d'évaluer si cette implémentation respecte l'architecture choisie.
```

### `security-auditor`

À utiliser pour les zones sensibles.

```text
Demande au subagent security-auditor de vérifier les risques de sécurité dans cette modification.
```

### `doctrine-specialist`

À utiliser pour Doctrine et les migrations.

```text
Demande au subagent doctrine-specialist de relire les entités, relations, repositories et migrations liés à ce changement.
```

### `test-writer`

À utiliser pour créer ou améliorer des tests.

```text
Demande au subagent test-writer de proposer puis d'ajouter les tests nécessaires pour cette fonctionnalité.
```

### `frontend-ui-designer`

À utiliser pour transformer un brief design en Twig/Tailwind.

```text
Demande au subagent frontend-ui-designer de créer cette page avec Twig, Tailwind et Stimulus si nécessaire, en respectant `DESIGN.md`.
```

### `deployment-advisor`

À utiliser pour préparer un déploiement.

```text
Demande au subagent deployment-advisor de préparer la checklist de déploiement pour ce projet.
```

### `bug-hunter`

À utiliser pour trouver la cause d'un bug.

```text
Demande au subagent bug-hunter d'analyser cette erreur et de trouver la cause racine avant de proposer une correction.
```

---

## MCP Context7

Le fichier `.mcp.json` peut contenir un serveur MCP Context7.

Exemple :

```json
{
  "mcpServers": {
    "context7": {
      "type": "http",
      "url": "https://mcp.context7.com/mcp"
    }
  }
}
```

Context7 peut aider Claude à consulter de la documentation récente ou spécifique à une version.

**Important — coût contexte des MCP :** chaque serveur MCP connecté charge ses définitions d'outils et son schéma dans la fenêtre de contexte au démarrage de chaque session, que tu l'utilises ou non. Ces définitions peuvent peser plusieurs milliers de tokens. C'est pourquoi Context7 est désactivé par défaut dans `settings.local.json` (`disabledMcpjsonServers`). N'active un serveur MCP que si tu l'utilises régulièrement dans ce projet. Pour les serveurs ponctuels, mieux vaut les activer temporairement que de les laisser charger en permanence.

Prompt conseillé :

```text
Utilise le skill context7-docs.

Vérifie la documentation actuelle pour [Symfony / Doctrine / API Platform / Tailwind / Stimulus / Stripe].

Adapte ensuite la solution à la version installée dans ce projet.
Ne remplace pas l'analyse du code local par la documentation.
```

---

## Gestion du contexte

Claude retraite l'intégralité de la conversation à chaque message : chaque tool result (diff Git, fichier lu, résultat de commande) s'accumule dans la fenêtre de contexte et est renvoyé à chaque tour. Deux commandes intégrées aident à gérer ça.

### `/context`

Affiche un détail complet de ce qui occupe la fenêtre de contexte : fichiers ouverts, tool results, définitions d'outils, tours de conversation, system prompt — avec le nombre de tokens par élément et l'usage total versus le plafond disponible. Utile pour repérer un fichier inutilement chargé ou décider s'il vaut mieux compacter ou repartir de zéro.

### `/compact`

Résume la session en une représentation compacte : décisions prises, code écrit, état de la tâche en cours, erreurs résolues. Ce résumé devient la nouvelle base de contexte.

Ce qui est conservé : décisions architecturales, fichiers modifiés, tâches en cours, blocages ouverts.  
Ce qui est perdu : raisonnements intermédiaires, approches abandonnées, tool results bruts.

**Utilise `/compact` proactivement à la fin d'une phase de travail**, pas quand Claude commence déjà à perdre le fil. Une session saine produit un meilleur résumé qu'une session dégradée.

Si tu passes à une tâche sans rapport avec la précédente, préfère `/clear` : ça vide le contexte complètement sans fermer le terminal.

---

## Sécurité

Ce template autorise la lecture de `.env` car il peut servir de template de variables.

En revanche, Claude ne doit pas lire :

```text
.env.local
.env.prod
secrets/**
*.pem
*.key
```

Les commandes dangereuses sont bloquées ou doivent demander confirmation.

Exemples à éviter :

```bash
rm -rf
chmod -R 777
git reset --hard
git clean -fd
php bin/console doctrine:database:drop
php bin/console doctrine:schema:drop
```

---

## Configuration globale `~/.claude/`

En complément du dossier projet `.claude/`, Claude Code maintient un dossier global dans ton répertoire personnel.

```text
~/.claude/
├── CLAUDE.md          ← instructions personnelles chargées dans tous les projets
├── settings.json      ← permissions globales par défaut
├── commands/          ← commandes personnelles disponibles partout (/user:nom)
├── skills/            ← skills personnels disponibles partout
├── agents/            ← agents personnels disponibles partout
└── projects/          ← historique de sessions et mémoire automatique par projet
```

**Ce qui va dans `~/.claude/CLAUDE.md` (global) :**
- ton style de codage personnel ;
- tes préférences de communication avec Claude ;
- conventions que tu appliques sur tous tes projets.

**Ce qui reste dans `.claude/` (projet) :**
- stack, architecture, commandes du projet ;
- règles d'équipe à partager via Git ;
- agents et skills spécifiques au projet.

La mémoire automatique par projet (`~/.claude/projects/`) est gérée par Claude. Tu peux la consulter ou la vider avec `/memory`.

---

## Recommandation `.gitignore`

Dans chaque projet qui utilise ce template, ajoute :

```gitignore
# Claude Code local settings
.claude/settings.local.json
```

Ne mets pas `.mcp.json` dans le `.gitignore` si la configuration MCP est partageable.

Si un MCP contient des secrets ou tokens, utilise plutôt des variables d'environnement ou une configuration locale non versionnée.

---

## Workflow recommandé au démarrage d'un projet

1. Copier `.claude/`, `CLAUDE.md` et `.mcp.json`.
2. Ajouter `.claude/settings.local.json` au `.gitignore`.
3. Copier le template de profil projet.
4. Demander à Claude de remplir `.claude/project-profile.md` avec le skill `fill-todos`.
5. Choisir l'architecture.
6. Copier l'architecture choisie dans `.claude/rules/architecture.md`.
7. Choisir un `DESIGN.md` si le projet a une interface.
8. Lancer un audit projet.
9. Corriger les gros problèmes de contexte.
10. Commencer à coder avec les skills.

Prompt complet de démarrage :

```text
Utilise le skill init-project-context.

Je viens de copier le template Claude dans ce projet Symfony.

Analyse le projet et prépare le contexte Claude.

Tu dois :
1. lire `composer.json`, `symfony.lock`, `package.json`, `importmap.php` si présents ;
2. analyser rapidement `src/`, `templates/`, `assets/`, `tests/` ;
3. remplir `.claude/project-profile.md` ;
4. me recommander une architecture parmi classic-symfony, service-manager ou ddd-light ;
5. mettre à jour `CLAUDE.md` sans le rendre trop long ;
6. me dire quels skills sont les plus utiles pour ce projet ;
7. lister les informations manquantes sous forme de questions.

Ne mets aucune préférence personnelle.
Ne lis pas les fichiers interdits par `.claude/settings.json`.
```

---

## Mettre à jour ce template

Quand tu améliores ce repo template :

1. garde les fichiers courts ;
2. évite les doublons entre `CLAUDE.md`, `rules/`, `skills/` et `agents/` ;
3. mets les workflows dans `skills/` ;
4. mets les règles stables dans `rules/` ;
5. mets les gros exemples dans `_templates/` ;
6. évite les secrets ;
7. garde le template publiable.

---

## Philosophie

Ce template doit rester :

- complet ;
- modulaire ;
- lisible ;
- adaptable ;
- prudent ;
- compatible avec un usage professionnel ;
- utile sans être surchargé.

Le but n'est pas de forcer une architecture unique.

Le but est de donner à Claude Code un cadre clair pour travailler proprement sur des projets Symfony différents.
