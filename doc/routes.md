# Rotas

Foram criados um total de 14 rotas, sendo elas:
- Auth
  - Registrar: `[POST] /auth/register`
  - Login: `[POST] /auth/login`
  - Logout: `[GET] /auth/logout`
- Users
  - Listar: `[GET] /users`
  - Visualizar: `[GET] /users/{user}`
  - Atualizar: `[PUT] /users/{user}`
  - Apagar: `[DELETE] /users/{user}`
- Accounts
  - Registrar: `[POST] /accounts`
  - Visualizar: `[GET] /accounts/{account}`
  - Atualizar: `[PUT] /accounts/{account}`
  - Apagar: `[DELETE] /accounts/{account}`
- Transactions
  - Registrar: `[POST] /accounts/{account}/transactions`
- Account types
  - Listar: `[GET] /account_types`
- Transaction types
  - Listar: `[GET] /transaction_types`

----------

## Auth
- Prefixo: `auth`

**Registrar**:
`[POST] /auth/register`

- **Body**

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `name` | string | Sim | Mínimo de 3 e máximo de 255 caracteres. |
| `email` | string | Sim | E-mail válido e máximo de 255 caracteres, deve ser único nos `users`. |
| `cpf` | string | Sim | CPF válido (dígitos verificadores e tamanho), deve ser único nos `users` |
| `telephone` | string | Sim | Mínimo de 8 e máximo de 14 caracteres. |
| `password` | string | Sim | Mínimo de 8 e máximo de 255 caracteres, possui campo de confirmação (`password_confirmation`) com mesmo valor. |

Exemplo de request:
```json
{
  "name": "Álvaro Ferreira Pires de Paiva",
  "cpf": "171.745.911-08",
  "telephone": "+55 (84) 99841-2245",
  "email": "alvarofepipa@mail.com",
  "password": "alvarofpp",
  "password_confirmation": "alvarofpp"
}
```

Exemplo de response:
```json
{
  "message": "User registered successfully!",
  "data": {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmM4YmQ1OThhNzMwNDRhMWZmNGRkNjUxNjFlNmRkZmVhMDk2YjdkZDBlYTBiZjY4NjdhZjE4MjJmYTg4ZjA2ZjAzNGU4NGE0YWExZDIxZWYiLCJpYXQiOjE1OTM5NzU2MjQsIm5iZiI6MTU5Mzk3NTYyNCwiZXhwIjoxNTk0MDYyMDI0LCJzdWIiOiIyMyIsInNjb3BlcyI6W119.AbyzHMyC24p6C9dumV913zDxxKrHhmNe7miDHeXS8mJ7A4Mf3BOBj86wHzMh4-zPSd79BDPG-UyCDf_nLyImVQVahDC-V_623qGxFSjK7ZNOaBKR0fmgdAsBpQwGGfzgpfX2tlFJyycJbeQ_BF-Lhn6Mttk3_2EZIPFMR-7dABE96SraAq_ghFGcHtdF3OBpB-yIgJLrTWaTXBOjf_hbgcDjH_WC1R02uqKojQIfVmSDlP-oUYEExgh0kjwpxjigPIKU2MnZJRLN_K_b-Ku8MOdeRDehUWpO24uMkcUxd8RyBuN6Y1ZjM6Gssy0WL689NR_i0x8V4kr1G7CbYGO0jo2xKF9X11TfJ8uExpERbpwndAXaIefUe4q8NB0XoggV59soz0YgEzTdLbtVdCVabd5hIfdmAs7p1TjtGVYG4z_tqx1gjgMlzzO-A0nalvroBzjjlyqEHZV6v_OLwdbAXIVSFKn8A6fiV0KHxosDZjqMlZrBCCArwhlG0QwxwwcZbN6oA5vddiuebY0SIsuzANOqYcUxEqVQfzDDjBgYNP19HW5vnTij-4wYN83pnyrc4j5UYo-MQ8hmdFV8zzHj3SwgyyMw-4wYiB4z3sdbg9cJDJzuxNSQzdAejlLsl5oOxqukCa6wI2d3kPQCx4DtvtI68BzXdeicmz2dDj5TX_Y",
    "user": {
      "name": "Álvaro Ferreira Pires de Paiva",
      "email": "alvarofepipa@mail.com",
      "cpf": "17174591108",
      "telephone": "5584998412245",
      "updated_at": "2020-07-05T19:00:24.000000Z",
      "created_at": "2020-07-05T19:00:24.000000Z",
      "id": 23
    }
  }
}
```

**Login**:
`[POST] /auth/login`

- **Body**

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `email` | string | Sim | E-mail válido e máximo de 255 caracteres, deve existir em `users`. |
| `password` | string | Sim | Mínimo de 8 e máximo de 255 caracteres. |

Exemplo de request:
```json
{
  "email": "alvarofepipa@mail.com",
  "password": "alvarofpp"
}
```

Exemplo de response:
```json
{
  "data": {
    "token": {
      "access": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDMxYjc1ZWVjOGI4ZDNhY2E1NjlhYzkxZDQzMzAwNzdlYzU2ODZhZDEwZGIyZTE3YTE1OTBmMGRlZjUwMzVjM2QzMmQ4ZGRmOGM3MzE0OWMiLCJpYXQiOjE1OTM5Nzg2MzgsIm5iZiI6MTU5Mzk3ODYzOCwiZXhwIjoxNTk0MDY1MDM4LCJzdWIiOiIyMyIsInNjb3BlcyI6W119.n5UCDX0HB3h22iGUIbdnNLa5T8rxDvcJZaDfb8ojNTo87Ag6qHJF4me6z9WvCq_TI01i6BAcSsoYLr08ww5CAs3dhbA9E3jjlpR45L7J3yeal1dZdcCmwD6mAcfMRgrLI23Yeh1eYWGl1nYDt0E3D9aSEHwcYwDg4bo6-1NQl81eLky_0SRjXoqcIP_d2RS1YIS5PsiAdOwZ42po_FswOLRp4f0LsE96nTDdczO8qnhPAW1lXuchgzkxZ33_MJFX4IIs33aM200vdxnCMPTtEBIvDCKWrmckI5oYnTNmaOLQYszpJwVuj9oRQ9Nkaowm7b5X-yrj9ehW4NTQcNwP3eHuot18wxEtRq5ea8HHhau3SOo8FDX1xMevcpIGFHlMiSaYqRkU7k3IMbrNh3dgry9XyU9iw4z0K9WIBsMFMHs-9Ag0pXQmOp1-JYOZ8nIRLfHeSd-ua5ztYGWON8EB2w93cTg7phkF77F8jSMjbhra0Ciu7bnQTQBX0P34ul8OqVt_vKzZ7BjJbMvtwuKc4D9HSqyMdEfQT0bUcB2m2eJeZkqD7w3zu1hOy7N_nDXtdRWKYGhdIt7cAGhC92XYzH9WxhfLSKiMKCoNAxFoAcgRjpbmYksRl5VaUC3jdto8tELfav3KSG_TeKz_yrFg23Bu4QEAF6m0Ha6worStWd8",
      "expires": "2020-07-06 19:50:38"
    },
    "user": {
      "id": 23,
      "name": "Álvaro Ferreira Pires de Paiva",
      "cpf": "17174591108",
      "email": "alvarofepipa@mail.com",
      "email_verified_at": null,
      "telephone": "5584998412245",
      "remember_token": null,
      "created_at": "2020-07-05T19:00:24.000000Z",
      "updated_at": "2020-07-05T19:00:24.000000Z"
    }
  }
}
```

**Logout**:
`[GET] /auth/logout`

- **Validação**:
  - Deve existir sessão.

Exemplo de response:
```json
{
  "message": "Come back often!"
}
```

----------

## Users
- Prefixo: `users`

**Listar**:
`[GET] /users`

- **Validação**:
  - Deve existir sessão.

Exemplo de response:

`/users?q=Álvaro`
```json
{
  "data": [
    {
      "id": 23,
      "name": "Álvaro Ferreira Pires de Paiva",
      "cpf": "171.745.911-08",
      "telephone": "+55 (84) 99841-2245",
      "email": "alvarofepipa@mail.com"
    }
  ],
  "links": {
    "first": "http:\/\/localhost:8000\/api\/users?page=1",
    "last": "http:\/\/localhost:8000\/api\/users?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "http:\/\/localhost:8000\/api\/users",
    "per_page": 15,
    "to": 1,
    "total": 1
  }
}
```

`/users`
```json
{
  "data": [
    {
      "id": 1,
      "name": "Amanda Thalissa Fonseca Neto",
      "cpf": "417.292.234-19",
      "telephone": "(18) 4944-5912",
      "email": "sebastiao.ortega@example.com"
    },
    {
      "id": 2,
      "name": "Mário Ivan Delvalle Neto",
      "cpf": "890.435.986-40",
      "telephone": "(92) 2044-3187",
      "email": "mariana.gusmao@example.com"
    },
    {
      "id": 3,
      "name": "Dr. Helena Carrara Sobrinho",
      "cpf": "814.027.498-48",
      "telephone": "(67) 99258-5214",
      "email": "nicole.rodrigues@example.net"
    }
  ],
  "links": {
    "first": "http:\/\/localhost:8000\/api\/users?page=1",
    "last": "http:\/\/localhost:8000\/api\/users?page=2",
    "prev": null,
    "next": "http:\/\/localhost:8000\/api\/users?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "path": "http:\/\/localhost:8000\/api\/users",
    "per_page": 15,
    "to": 15,
    "total": 21
  }
}
```

**Visualizar**:
`[GET] /users/{user}`

- **Validação**:
  - Deve existir sessão.

Exemplo de response:
```json
{
  "data": {
    "id": 1,
    "name": "Álvaro Ferreira Pires de Paiva",
    "cpf": "171.745.911-08",
    "telephone": "+55 (84) 99841-2245",
    "email": "alvarofepipa@mail.com",
    "accounts": [
      {
        "id": 1,
        "bank_branch": "1013",
        "number": "164410",
        "digit": "8",
        "account_type": {
          "id": "p",
          "slug": "person",
          "name": "Pessoal",
          "description": "Conta pessoa."
        }
      },
      {
        "id": 3,
        "bank_branch": "1013",
        "number": "164410",
        "digit": "8",
        "account_type": {
          "id": "c",
          "slug": "company",
          "name": "Empresarial",
          "description": "Conta empresarial."
        },
        "company": {
          "cnpj": "56.805.014\/0001-37",
          "company_name": "Teste social",
          "trading_name": "Teste fantasia"
        }
      }
    ]
  }
}
```

**Atualizar**:
`[PUT] /users/{user}`

- **Validação**:
  - Deve existir sessão;
  - Ser o usuário responsável pelos conta atualizada.

- **Body**

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `name` | string | Não | Mínimo de 3 e máximo de 255 caracteres. |
| `email` | string | Não | E-mail válido e máximo de 255 caracteres, deve ser único nos `users`. |
| `cpf` | string | Não | CPF válido (dígitos verificadores e tamanho), deve ser único nos `users` |
| `telephone` | string | Não | Mínimo de 8 e máximo de 14 caracteres. |
| `password` | string | Não | Mínimo de 8 e máximo de 255 caracteres, possui campo de confirmação (`password_confirmation`) com mesmo valor. |

Exemplo de request:
```json
{
  "name": "Álvaro Álvaro Álvaro"
}
```

Exemplo de response:
```json
{
  "message": "User updated successfully!",
  "data": {
    "id": 23,
    "name": "Álvaro Álvaro Álvaro",
    "cpf": "171.745.911-08",
    "telephone": "+55 (84) 99841-2245",
    "email": "alvarofepipa@mail.com",
    "accounts": [
      {
        "id": 1,
        "bank_branch": "1013",
        "number": "164410",
        "digit": "8",
        "account_type": {
          "id": "p",
          "slug": "person",
          "name": "Pessoal",
          "description": "Conta pessoa."
        }
      },
      {
        "id": 3,
        "bank_branch": "1013",
        "number": "164410",
        "digit": "8",
        "account_type": {
          "id": "c",
          "slug": "company",
          "name": "Empresarial",
          "description": "Conta empresarial."
        },
        "company": {
          "cnpj": "56.805.014\/0001-37",
          "company_name": "Teste social",
          "trading_name": "Teste fantasia"
        }
      }
    ]
  }
}
```

**Apagar**:
`[DELETE] /users/{user}`

- **Validação**:
  - Deve existir sessão;
  - Ser o usuário responsável pelos conta atualizada.

Exemplo de response:
```json
{
  "message": "User successfully deleted!"
}
```

----------

## Accounts
- Prefixo: `accounts`

**Registrar**:
`[POST] /accounts`

- **Validação**:
  - Deve existir sessão.

- **Body**

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `bank_branch` | string | Sim | Mínimo de 4 e máximo de 6 caracteres. |
| `number` | string | Sim | Mínimo de 5 e máximo de 6 caracteres. |
| `digit` | string | Sim | Tamanho de 1 caractere. |
| `account_type_id` | string | Sim | Ser um tipo de conta válido (verificar rota `[GET] /account_types`). O usuário na sessão não pode ter mais de uma conta por tipo. |

Caso o `account_type_id` seja do tipo de conta empresarial, os seguintes campos são validados:

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `cnpj` | string | Sim | CNPJ válido e único em `companies`. |
| `company_name` | string | Sim | Mínimo de 1 e máximo de 255 caracteres. |
| `trading_name` | string | Sim | Mínimo de 1 e máximo de 255 caracteres. |

Exemplo de request:
```json
{
  "bank_branch": "1013",
  "number": "16441-0",
  "digit": "8",
  "account_type_id": "c",
  "cnpj": "56.805.014/0001-37",
  "company_name": "Teste social",
  "trading_name": "Teste fantasia"
}
```

Exemplo de response:
```json
{
  "message": "Account created successfully!",
  "data": {
    "id": 41,
    "bank_branch": "1013",
    "number": "164410",
    "digit": "8",
    "account_type": {
      "id": "c",
      "slug": "company",
      "name": "Empresarial",
      "description": "Conta empresarial."
    },
    "company": {
      "cnpj": "56.805.014\/0001-37",
      "company_name": "Teste social",
      "trading_name": "Teste fantasia"
    }
  }
}
```

**Visualizar**:
`[GET] /accounts/{account}`

- **Validação**:
  - Deve existir sessão.

Exemplo de response:
```json
{
  "data": {
    "id": 41,
    "bank_branch": "1013",
    "number": "164410",
    "digit": "8",
    "account_type": {
      "id": "c",
      "slug": "company",
      "name": "Empresarial",
      "description": "Conta empresarial."
    },
    "company": {
      "cnpj": "56.805.014\/0001-37",
      "company_name": "Teste social",
      "trading_name": "Teste fantasia"
    },
    "user": {
      "id": 24,
      "name": "Álvaro Ferreira Pires de Paiva",
      "cpf": "171.745.911-08",
      "telephone": "+55 (84) 99841-2245",
      "email": "alvarofepipa@mail.com"
    },
    "transactions": []
  }
}
```

**Atualizar**:
`[PUT] /accounts/{account}`

- **Validação**:
  - Deve existir sessão;
  - Ser o usuário responsável pela conta.

- **Body**

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `bank_branch` | string | Não | Mínimo de 4 e máximo de 6 caracteres. |
| `number` | string | Não | Mínimo de 5 e máximo de 6 caracteres. |
| `digit` | string | Não | Tamanho de 1 caractere. |
| `account_type_id` | string | Não | Ser um tipo de conta válido (verificar rota `[GET] /account_types`). O usuário na sessão não pode ter mais de uma conta por tipo. |

Caso o `account_type_id` seja do tipo de conta empresarial, os seguintes campos são validados:

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `cnpj` | string | Não | CNPJ válido e único em `companies`. |
| `company_name` | string | Não | Mínimo de 1 e máximo de 255 caracteres. |
| `trading_name` | string | Não | Mínimo de 1 e máximo de 255 caracteres. |

Exemplo de request:
```json
{
  "number": "16441-3",
  "company_name": "Teste social update 2"
}
```

Exemplo de response:
```json
{
  "message": "Account updated successfully!",
  "data": {
    "id": 41,
    "bank_branch": "1013",
    "number": "164413",
    "digit": "8",
    "account_type": {
      "id": "c",
      "slug": "company",
      "name": "Empresarial",
      "description": "Conta empresarial."
    },
    "company": {
      "cnpj": "56.805.014\/0001-37",
      "company_name": "Teste social",
      "trading_name": "Teste fantasia"
    }
  }
}
```

**Apagar**:
`[DELETE] /accounts/{account}`

- **Validação**:
  - Deve existir sessão;
  - Ser o usuário responsável pela conta.

Exemplo de response:
```json
{
  "message": "Account successfully deleted!"
}
```

----------

## Transactions
- Prefixo: `accounts/{account}/transactions`

**Registrar**:
`[POST] /accounts/{account}/transactions`

- **Validação**:
  - Deve existir sessão;
  - Ser o usuário responsável pela conta.

- **Body**

| Campo | Tipo | Obrigatório | Especificações |
| ----- | ---- | ----------- | -------------- |
| `value` | numeric | Sim | - |
| `transaction_type_id` | string | Sim | Ser um tipo de transação válido (verificar rota `[GET] /transaction_types`). |
| `account_to_id` | int | Sim | Identificador de conta existente. |

Exemplo de request:
```json
{
  "value": 96.66,
  "account_to_id": 49,
  "transaction_type_id": "cpr"
}
```

Exemplo de response:
```json
{
  "message": "Transaction successfully registered!",
  "data": {
    "id": 1,
    "value": 96.66,
    "created_at": "06/07/2020 - 15:53:22",
    "transaction_type": {
      "id": "cpr",
      "name": "Recarga de Celular"
    },
    "from": {
      "account": {
        "id": 58,
        "bank_branch": "7510",
        "number": "47833",
        "digit": "5",
        "account_type": {
          "id": "c",
          "slug": "company",
          "name": "Empresarial",
          "description": "Conta empresarial."
        },
        "company": {
          "cnpj": "57.473.091/0001-08",
          "company_name": "Rivera e Medina Ltda.",
          "trading_name": "Rivera e Medina Ltda. S.A."
        }
      },
      "user": {
        "id": 29,
        "name": "Ariadna Maia Benites Jr.",
        "cpf": "006.203.546-07",
        "telephone": "(64) 4741-6380",
        "email": "nbezerra@example.net"
      }
    },
    "to": {
      "account": {
        "id": 49,
        "bank_branch": "6275",
        "number": "72302",
        "digit": "7",
        "account_type": {
          "id": "p",
          "slug": "person",
          "name": "Pessoal",
          "description": "Conta pessoa."
        }
      },
      "user": {
        "id": 25,
        "name": "Ziraldo Zaragoça Neto",
        "cpf": "840.144.187-07",
        "telephone": "(21) 92827-4028",
        "email": "emilia09@example.net"
      }
    }
  }
}
```

----------

## Account types
- Prefixo: `account_types`

**Listar**:
`[GET] /account_types`

Exemplo de response:
```json
{
  "data": [
    {
      "id": "c",
      "slug": "company",
      "name": "Empresarial",
      "description": "Conta empresarial."
    },
    {
      "id": "p",
      "slug": "person",
      "name": "Pessoal",
      "description": "Conta pessoa."
    }
  ]
}
```

----------

## Transaction types
- Prefixo: `transaction_types`

**Listar**:
`[GET] /transaction_types`

Exemplo de response:
```json
{
  "data": [
    {
      "id": "bp",
      "name": "Pagamento de Conta"
    },
    {
      "id": "d",
      "name": "Depósito"
    },
    {
      "id": "t",
      "name": "Transferência"
    },
    {
      "id": "cpr",
      "name": "Recarga de Celular"
    },
    {
      "id": "pc",
      "name": "Compra (Crédito)"
    }
  ]
}
```
