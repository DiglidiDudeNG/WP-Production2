# Projet de Production 2

**Membres de l'équipe:**
+ Chloé Drolet-Tremblay
+ Karine Boisvert
+ Sylvie Dubé
+ Jonathan Martin 
+ Félix Dion Robidoux

## Instructions de clônage

#### Clônage

1. Clônez le repo sur votre machine.
2. Faites un alias sur votre installation de EasyPHP/MAMP/LAMP/WAMP/etc.
3. Créez-vous une branche.
4. Pushez la branche.

#### Configurations

5. Copiez le fichier `'local-config.sample.php'` et renommez-le `'local-config.php'` (Gardez l'original avec le sample à la fin)
6. Changez les constantes à l'intérieur pour la base de données (`DB_NAME`, `DB_USER`, `DB_PASSWORD` et `DB_HOST`)
  * __NOTE DE FÉLIX:__ Normalement, vous devriez pas avoir à changer ça. Faites juste être conscient des valeurs (spécialement le nom de la BD).
7. Dans PhpMyAdmin, créez une nouvelle base de données nommée `DB_NAME` que vous avez mis dans `local-config.php`.
8. Faites l'installation de Wordpress normalement.

#### Branches

9. Créez-vous une branche à la syntaxe suivante : `pn-partie-section` où
  * `pn` est vos initiales
  * `partie` est la partie du travail que vous faites
    * `plugin` pour ce qui touche aux __plugins__.
    * `theme` pour ce qui touche aux __thèmes__.
    * `doc` pour la __documentation__.
    * _Ajoutez d'autres parties si on en a besoin..._
  * `section` est un mot ou un court groupe de mot séparé par des underscore `_` qui englobe ce dont vous allez vous occuper dans cette branche.
  * __Exemple typique d'une branche:__ `fdr-plugin-post_type`

## Plugin

Pour l'instant, référez-vous à `content/plugins/reserv-billets/README.md`
EN CONSTRUCTION

### Structure

```INI
./ (ROOT)
./reserv_billets.php (Commentaire des infos du plugin, appèle la classe de base)
./uninstall.php (S'occupe de la désinstallation; La suppression du plugin)
---
admin/ (PANNEAU D'ADMINISTRATION)
admin/*.*
admin/css/
---
includes/ (CLASSES DE BASE DU PLUGIN)
includes/class-rb-spectacle-loader.php (Classe utilitaire qui queue les actions et les filtres)
includes/class-rb-spectacle.php (Classe de base, relie tout)
---
partials/ (INTÉGRATION)
partials/rb-spectacle-metabox.php (HTML du metabox du type Spectacle)
```
_^ SUJET À CHANGEMENTS !!!_

## Thèmes

Pour l'instant, référez-vous à `content/plugins/reserv-billets/README.md`

### Structure

TO BE DECIDED