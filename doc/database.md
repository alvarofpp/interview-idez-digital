# Banco de dados

Para esse documento, foram ignoradas as tabelas criadas automaticamente pelo Laravel.

![diagrama_banco_dados](idezdigital-database.png)

Foram criadas um total de 6 tabelas:

- **users**: contêm os dados dos usuários;
- **account_types**: os tipos de contas disponíveis no sistema. É alimentado por um seed no servidor;
- **transaction_types**: os tipos de transações disponíveis no sistema. É alimentado por um seed no servidor;
- **accounts**: contêm os dados das contas vinculadas aos usuários;
- **companies**: contêm dados especificos de contas empresariais;
- **transactions**: contêm os dados das transações realizadas.

Trabalhos futuros:
- Implementar _soft delete_ nas tabelas desejadas;

**Observações**:
- Tabelas de tipos (`account_types` e `transaction_types`) possuem `varchar` como tipo de chave primária. Optou-se por essa decisão visando facilitar o entedimento de consultas realizadas no banco de dados.
- Como os dados pedidos para contas pessoais são as presentes na tabela `users`, optou-se por não criar uma tabela para essa finalidade, tendo em vista que as contas são vinculadas a um usuário, logo é fácil o acesso a esses dados.
- Em `transactions`, as chaves `account_from_id` e `account_to_id` estão com seus `on update` e `on delete` como `SET NULL`. Optou-se por isso a fim de preservar a transação mesmo quando as contas são apagadas, para a realização de analises nesses dados.
