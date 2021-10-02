<h1>CRUD - IPDV</h1>
<h2>Overview</h2>
<p>A APLICAÇÃO FOI MONTADA SOB O PADRÃO ARQUITETURAL MVC.
Busca também adaptar alguns padrões comportamentais e criacionais ao longo de sua implementação!
Arquitetura do Software é escalar!
o index está na pasta public na intenção de não ceder acesso à raiz da aplicação 
(em produção seria setado um VHost pra public)
Na raiz do projeto foi posto um .htaccess bem simples com Options -Indexes para que não seja acessado 
o diretório da aplicação através do browser
Mais comentários em cada classe...</p>

<h2>Pré-Requisitos</h2>
<ul>
    <li>PostgreSQL - https://www.enterprisedb.com/downloads/postgres-postgresql-downloads</li>
    <li>Criação do Banco - Script de criação em app/database/scripts</li>
    <li>Servidor Apache - de preferência com "AllowOverride All" pra raiz do apache(htdocs,public_html, www, etc.). </li>
    <li>PHP - v 7.4 (versão utilizada - projeto não foi testado em outras versões) com extensão pdo_pgsql habilitada;</li>
    <li>PgAdmin4 ou qualquer outro gerenciador de banco de dados PostgreSQL</li>
</ul>
<h2>Instruções</h2>
<ol>
    <li>Na raiz do Apache execute o comando: git clone https://github.com/leoguedesf15/crud_ipdv.git</li>
     <li>Logo após execute php composer install</li>
    <li>Executar os scripts da seguinte maneira: (scripts em app/database/scripts)
        <ol>
            <li>executar create_database.sql</li>
            <li>Conecte-se no banco recém criado</li>
            <li>create_tables.sql</li>
        </ol>
    </li>
    <li>Abrir o arquivo app/database/DatabaseConfig.php e personalizar as configurações de acesso ao banco (user, senha e porta).</li>
    <li></li>
</ol>
