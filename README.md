# Desafio Backend

## Problema
A idez é uma fintech que busca oferecer tecnologia de ponta para outras empresas do ecosistema financeiro. Um dos passos necessários para completarmos essa missão é implementar a criação de contas para utilização do nosso aplicativo em diferentes plataformas. 
É importante lembrar que o seu sistema será integrado aos nossos painéis internos e ao aplicativo.

Todo o processo começa com a criação de um Usuário. Um usuário pode ter mais de um tipo de conta vinculada a ele. 
De um **Usuário (User)**, queremos saber seu `Nome Completo`, `CPF`, `Número de Telefone`, `e-mail` e `Senha`. 
CPFs e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

Os tipos de conta que existem na idez são **Empresarial (Company)** e **Pessoal (Person)**. Todas as contas sempre estarão vinculadas a um usuário e possuem alguns dados em comum: `Id da Conta`, `Agência`, `Número` e `Dígito`. 
De uma conta empresarial queremos saber a `Razão Social`, o `Nome Fantasia`, o `CNPJ`, além do `id de Usuário` que será dono dessa conta. 
De uma conta pessoal, queremos saber apenas seu `Nome` e `CPF`, além do `id de Usuário` que será dono dessa conta. 

Os documentos (cpf e cnpj) devem ser únicos dentro do sistema, mesmo entre contas de tipos diferentes.
Devido a algumas limitações do sistema, **cada Usuário pode ter apenas uma conta de cada tipo**.

Seu sistema deve ser capaz de listar todos os usuários, além de conseguir trazer informações detalhadas de um usuário específico. 
Durante a listagem, deve ser possível filtar os resultados por `Nome` ou `Documento`.
Para fins didáticos, sua busca deve considerar apenas resultados que comecem com a string especificada na busca. Como exemplo,
`GET /users?q=joao` deve retornar apenas Usuários cujos Nomes comecem com a string **joao**. 
Não há a necessidade de lidar com acentos.

Outra funcionalidade do sistema deve ser a possiblidade de contas poderem realizar **Transações (Transactions)**. Cada transação deverá ter um valor, positivo ou negativo, além de um dos cinco `Tipos` de operação que fazemos: 
- Pagamento de Conta
- Depósito
- Transferência
- Recarga de Celular
- Compra (Crédito)

O sistema precisará listar todas as informações de uma conta, incluindo as suas transações e usuários relacionados em um único endpoint: `/accounts/{id}`.

Sua tarefa é desenvolver uma API capaz de cumprir com todos os requisitos especificados. 


## Instruções
Para ajudar no desenvolvimento e evitar perda de tempo com código *boilerplate*, decidimos prover uma estrutura básica para o desenvolvimento da sua solução utilizando a plataforma PHP (Laravel 7.* + Postgres).
A estrutura **deve** ser utilizada no desenvolvimento da sua solução. 

Você poderá fazer um fork nesse repositório e trabalhar a partir daí.

O primeiro passo para o início do desenvolvimento é escolher qual tecnologia de banco de dados será utilizada no seu projeto. Dependendo da escolha, existem algumas alterações que devem ser feitas no seu projeto base.

- Copie o arquivo `.env.example` e salve como `.env`.

Para verificar se a sua solução está funcionando, utilize o comando `docker-compose up --build` a partir do diretório raiz do projeto. 
A sua API estará mapeada para a porta `8000`do seu host local. Uma requisição `GET localhost:8000/` vai retornar a versão do Laravel em execução.

**IMPORTANTE:** após a execução do `docker-compose up -d`, na pasta do projeto, execute o comando `docker-compose run web composer install` e em seguida `docker-compose run web php artisan key:generate`.
Quando o volume atual é mapeado para dentro do container, ele sobrescreve a pasta com as dependências instaladas pelo composer, por isso o comando é necessário. 

## Avaliação
A avaliação da sua solução será constituída de duas etapas principais: **Correção objetiva** e **Correção qualitativa**. 

Caso você não se sinta à vontade com a arquitetura proposta, você pode apresentar sua solução utilizando frameworks diferentes. 
Porém, nesse caso, uma entrevista de **Code Review** será necessária para a avaliação da sua solução.

A correção objetiva será realizada através da utilização de um script de correção automatizada. A correção qualitativa levará em conta os seguintes critérios:

* Modelagem de Dados
* Domínio da Linguagem
* Legibilidade do Código
* Estrutura do Código
* Organização do Código
* Design Patterns
* Manutenibilidade do Código
* Diferenciais: Testes Unitários e Cobertura de Testes

## Como submeter
Ao finalizar envie uma chamada para o nosso slack (a url está no e-mail. Se não a tiver, pergunte ao seu(sua) recrutador(a)) com seu Nome, email e link para o repositório com a solução do desafio. 
Caso já esteja em processo de avaliação, é interessante também informar o(a) seu(sua) recrutador(a) sobre a conclusão desta etapa.

**Lembre-se de não enviar arquivos compilados e configurações de IDE ao submeter a sua solução.** 