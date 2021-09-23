<h1>CRUD - IPDV</h1>
<h2>Pré-Requisitos</h2>
<ul>
    <li>PostgreSQL - https://www.enterprisedb.com/downloads/postgres-postgresql-downloads</li>
    <li>Criação do Banco - Script de criação em app/database/scripts</li>
    <li>Servidor Apache - de preferência com "AllowOverride All" pra raiz do apache(htdocs,public_html, www, etc.). </li>
    <li>PHP - v 7.4 (versão utilizada - projeto não foi testado em outras versões) com extensão pdo_pgsql habilitada;</li>
    <li>PgAdmin4 ou qualquer outro gerenciador de banco de dados PostgreSQL</li>
</ul>

<h2>Implantação</h2>
<ol>
    <li>Na raiz do Apache execute o comando: git clone https://github.com/leoguedesf15/crud_ipdv.git</li>
    <li>Executar os scripts da seguinte maneira: (scripts em app/database/scripts)
        <ol>
            <li>executar create_database.sql</li>
            <li>Conecte-se no banco recém criado</li>
            <li>create_tables.sql</li>
            <li>create_objects.sql</li>
        </ol>
    </li>
    <li>Criar um virtualHost chamado com ServerName crud_ipdv.local apontando o DocumentRoot para crud_ipdv/public (Modificar também o arquivo de Hosts do SO incluindo o domínio e apontando pro IP de localhost)</li>
    <li>Abrir o arquivo app/database/DatabaseConfig.php e personalizar as configurações de acesso ao banco (user, senha e porta).</li>
    <li>Acessar o projeto em http://localhost/crud_ipdv ou https://localhost/crud_ipdv (caso o ambiente local possua SSL configurado)</li>
</ol>