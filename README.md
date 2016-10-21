blog
====


--------------UTILISATION DU REPOSITORY------------------------------         
A retenir, grace au repository, je peux faire un:
select * form "table" where propriété:value

Grace à la syntaxe du repository on peut récupérer une table entière de donnée grace au
findAll(); en précisant la nom de l'entity à selectionner
$profil = $em->getRepository("AdminBundle:Profil")->findAll();

ou juste sélectionner par nom, email, pseudo grace à la syntaxe:
$profil = $em->getRepository("AdminBundle:Profil")->findByName();

findBy...(); exemple si je veux récupérer par email:
findByEmail('nom de l'email');
ou par ville:
findByVille('Lunel')
Ou par apprennant:
findByApprennant('beWeb').....ect...etc..
-------------------------IMPORTANT--------------------------------------
findByName(''); --> la partie "Name", 
représente le nom d'une colonne qui nous intéresse dans une entity
------------------------------------------------------------------------
