## database
1. crie uma nova mysql database (default name = "seminario-project" modificar em config.php)
2. importe o sql schema (seminario-project.sql) usando phpmyadmin ou mysql cli.

### phpmyadmin
1. selecione a nova database
2. clique em import
3. selecione o arquivo schema (seminario-project.sql)

### mysql cli
1. mysql -u localhost -p seminario-project < path/seminario-project.sql
