<h1> TP symfony </h1>
<h2> Auteur : François Axel (fran0138)</h2>
<br>
<h2> Installation / Configuration</h2>
<h3> Ajout dans le composeur.json: </h3>
<p> 
"start" : [ <br>
            "Composer\\Config::disableProcessTimeout",<br>
            "symfony serve"<br>
        ], 
<br>
-> Qui lance le serveur web symfony avec la commande composer start
</p>
<p>      
"fix:cs": [ <br>
            "php-cs-fixer fix" <br>
        ],
<br>
-> Qui lance la commande de correction du code par PHP CS Fixer
</p>
<p>
"test:cs" : [ <br>
            "php-cs-fixer fix --dry-run" <br>
            ],
<br>
-> Qui lance la commande de vérification du code par PHP CS Fixer 
</p>
<p>
"test:codecept": [ <br>
                "php vendor/bin/codecept run" <br>
                ],
<br>
-> Qui lance les test avec codeception
</p>
<p>
"test": [ <br>
        "@test:cs", <br>
        "@test:codecept" <br>
        ],
<br>
-> Qui lance : le script Composer qui teste la mise en forme du code et le script Composer des tests avec Codeception
</p>
<p>
Dans la partie 16.5 nous avons rajouter les éléments suivant dans le composer.json
</p>
<p>
"db" : [ <br>
"php bin/console doctrine:database:drop --force --if-exists" -> Destruction forcée de la base de données <br>
"php bin/console doctrine:database:create"-> Création de la base de données <br>
"php bin/console doctrine:migrations:migrate --no-interaction" -> Application des migrations successives sans questions interactives <br> 
"php bin/console doctrine:fixtures:load --no-interaction" -> Génération des données factices sans questions interactives <br>
],
</p>
<p>On modifie le script test:codecept de la façon suivante :</p>
<p>
"test:codecept": [ <br>
            "php bin/console doctrine:database:drop --force --quiet --env=test"-> Destruction silencieuse forcée de la base de données <br>
            "php bin/console doctrine:database:create --quiet --env=test"-> Création silencieuse de la base de données <br>
            "php bin/console doctrine:schema:create --quiet --env=test"-> Création silencieuse du schéma de la base de données <br>
            "php vendor/bin/codecept run"
        ],
</p>

<h3>Documentation de la base de donnée</h3>
<p>Pour la création de notre base de données, nous avons réalisé une migration de la base de données de Mr.Cutrona
et nous avons par la suite généré les 150 éléments de la table contacts grâce à la classe ContactFactory et aux méthodes faker</p>

<h3>Création des utilisateur de démonstration</h3>
<p><strong>les identifiants des utilisateurs pour la démonstrations sont : </p>
<p>Jérôme Cutrona : role [admin], id=11, email= "root@example.com" mot de passe ='test'</p>
<p>Antoine Jonquet : role [user], id=12, email= "user@example.com" mot de passe ='test</p>