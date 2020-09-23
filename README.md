# Prj_Ainet


# Instalação do Repositório GitHub (Admin):
Nota: Basta um efetuar estas 8 seguintes configurações:
1 - Instação do GitHub Desktop;
2 - Criação do Repositório local;
3 - Dar o nome pjr;
4 - Selecionar o Caminho exemplo : Ainet/ainet / ou seja vai criar a pasta pjr (nome que demos);
5 - Adicionar os Colaboradores no site do github (quem cria / eles tem de aceitar no mail);
6 - Colocar os ficheiros clean na pasta prj;
7 - Fazer o primeiro commit "Frist Commit" no GitHub Desk;
8 - Fazer o push;

# Colaboradores
1 - Instação do GitHub Desktop;
2 - Aceitar o repositório no GitHub através do mail;
3 - No GitHub Desk selecionar o repositório e clicar clone;
4 - Selecionar o Caminho exemplo : Ainet/ainet;
5 - Fazer pull dos ficheiros;

# Colaboradores e Admin
1 - Corrigir os ficheiros da database com os ficheiros do moodle;
2 - Corrigir o ficheiro .env ( este ficheiros de configuração não são enviados através do git )
3 - Garantir que o caminho para a pasta está bem definido no homestead.yaml
4 - Efetuar o vagrant reload --provision
5 - vagrant ssh
6 - mudar para a pasta prj
7 - composer install
8 - composer update
9 - php artisan migrate 
10 - composer dump-autoload
11 - php artisan db:seed

Configuração concluida;

-----------------------------------------------------------------------

Todo: Criar vista para apresentar tabelas que mais tarde pode ser usada pelas 3 classes -> Users, Aeronaves, Movimentos
Eg:(Estas 3 classes descendem desta view que aprsenta tabelas e esta descende da master)

-----------------------------------------------------------------------

Duvidas para tirar no gabinete:
	-Conta horas aeronaves
	-Informação em tabelas ou shows? -- Check
	-Saber paginação (apresentar dados nas em varias paginas)
	-Comboboxes nos users (pilotos/nao pilotos etc...)
	-Fotos users --CHeck
	-Testes -- Check (softDelete)
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

