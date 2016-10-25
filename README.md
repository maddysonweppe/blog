blog
====

Langages, Outils, frameworks utilisaient:
==
- LINUX	(UBUNTU)
- BOOTSTRAP 3
- NETBEANS 8
- PHP 5
- HTML5
- CSS3
- JQUERY 1.12
- MYSQL
- SYMFONY 3
- GITHUB : <https://github.com/maddysonweppe/blog>
- TRELLO : <https://trello.com/b/UTrsRmwy/blog>
- FRAMAPAD : <https://mypads.framapad.org/mypads/?/mypads/group/certiblog-ozd3x7sz/pad/view/carnet-de-bord-god6x7n5>

Etape à suivre pour installer le projet "BLOG" après l'avoir téléchargé:
==
1. Commencer par mettre les droits sur le dossier
2. Faire un composer install dev 
3. paramétrer le fichier parameters.yml 
4. mettre à jour votre base de données 
5. mettre les droits au dossier nouvellement créé
6. il faut créer / pousser les entities dans votre base de données via le terminal avec la commande:  
php bin/console doctrine:schema:create
7. Projet FONCTIONNEL, vous pouvez commencer à naviguer!  
ATTENTION, vos entities dans la base de données sont vierges, cela impacte forcément la vue.