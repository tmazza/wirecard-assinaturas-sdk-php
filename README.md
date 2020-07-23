## Sobre

SDK PHP para facilitar o uso da [API de Assinaturas da Wirecard](https://dev.wirecard.com.br/v1.5).

## Uso

### Exemplo

```php
<?php
use tmazza\WirecardSubscriptions\WirecardApi;

$wirecardApi = new WirecardApi();


# Lista de planos
$plans = $wirecardApi->plans->all();

foreach($plans as $plan) {
    // $plan->code
}

# Criação de usuário
$wirecardApi->customers->create([ ... ]); 

# Criação de assinatura
$wirecardApi->subscriptions->create([ ... ]); 

# Consulta de assinatura
$wirecardApi->subscriptions->get('code');

```

### Instalação
<pre>composer require tmazza/wirecard-assinaturas-sdk-php</pre>

### Credenciais

Defina as variáveis de ambiente `WIRECARD_SUBSCRIPTIONS_ENV`,  `WIRECARD_SUBSCRIPTIONS_TOKEN` e `WIRECARD_SUBSCRIPTIONS_KEY`, para especificar, respectivamente o ambiente o token e a chave da integração da Wirecard. O ambiente *default* utilizado será o de *sandbox*.

Alternativamente o ambiente e as credenciais podem ser definidas na criação da classe da API, passando os parâmetros conforme: `new WirecardApi('sandbox', 'token', 'key')`. Esses parâmetros terão precedência sob as variáveis de ambiente.


---
## API

Todos os recursos possuem os métodos `get()`, `all()`, `create()` e  `update()` além de métodos específicos configurando cada um dos parâmetros disponíveis na API.

### Tratamento de erros
```php
try {
  
  $wirecardApi = new WirecardApi();
  $wirecardApi->plans->create(['...']);

} catch (ValidationException $e) {

  // status 400 - reporte de erro da API Wirecard
  $e->errors(); 
  $e->alerts();
  $e->firstError();
  $e->firstAlert();

} catch (GuzzleHttp\Exception\ClientException $e) {
  
  // status 401 a 499  

} catch (GuzzleHttp\Exception\ServerException $e) {
  
  // status 500 a 599
  
} 
```

### Recursos
#### ASSINATURAS

- **Planos**
    - [Criar plano](#criar-plano)
    - [Listar Planos](#listar-planos)
    - [Consultar Plano](#consultar-plano)
    - [Ativar Plano](#ativar-plano)
    - [Desativar Plano](#desativar-plano)
    - [Alterar Plano](#alterar-plano)

- **Assinantes**
    - [Criar Assinante](#criar-assinante)
    - [Listar Assinantes](#listar-assinantes)
    - [Consultar Assinante](#consultar-assinante)
    - [Alterar Assinante](#alterar-assinante)
    - [Atualizar Cartão do Assinante](#atualizar-cartão-do-assinante)

- **Assinaturas**
    - [Criar Assinaturas](#criar-assinaturas)
    - [Listar Todas Assinaturas](#listar-todas-assinaturas)
    - [Consultar Detalhes de Uma Assinatura](#consultar-detalhes-de-uma-assinatura)
    - [Suspender Assinatura](#suspender-assinatura)
    - [Reativar Assinatura](#reativar-assinatura)
    - [Cancelar Assinatura](#cancelar-assinatura)
    - [Alterar Assinatura](#alterar-assinatura)
    - [Alterar o método de pagamento](#alterar-o-método-de-pagamento)

#### PAGAMENTOS
- **Faturas**
    - Listar Todas as Faturas de Uma Assinatura
    - Consultar Detalhes de Uma Fatura

- **Pagamentos**
    - Listar Todos os Pagamentos de Uma Fatura
    - Consultar Detalhes de Um Pagamento da Assinatura

- **Cupons**
    - Criar Cupom
    - Associar um Cupom a Assinatura Existente
    - Associar um Cupom a uma Nova Assinatura
    - Consultar Cupom
    - Listar Todos os Cupons
    - Ativar e Inativar Cupons
    - delete Excluir Cupom de uma Assinatura

- **Retentativas**
    - Retentativa de pagamento de uma fatura
    - Gerar um novo boleto para uma fatura
    - Criar Regras de Retentativas Automáticas
    
#### NOTIFICAÇÕES
- **Preferências de notificação**
    - Criar Preferência de Notificação (webhook)

## Planos

#### Criar plano
```php
<?php
$plan = $wirecardApi->plans->create([
  "code" => "plan101",
  "name" => "Plano Especial",
  "description" => "Descrição do Plano Especial",
  "amount" => 990,
  "setup_fee" => 500,
  "max_qty" => 1,
  "interval" => [
    "length" => 1,
    "unit" => "MONTH"
  ],
  "billing_cycles" => 12,
  "trial" => [
    "days" => 30,
    "enabled" => true,
    "hold_setup_fee" => true
  ],
  "payment_method" => "CREDIT_CARD"
]);

echo $plan->name; // Plano Especial
```

#### Listar Planos
```php
<?php
$plans = $wirecardApi->plans->all();

foreach($plans as $plan) {
    echo $plan->name; // Plano Especial
}
```

#### Consultar Plano
```php
<?php
$plan = $wirecardApi->plans->get('plan101');
echo $plan->name; // Plano Especial
```

#### Ativar Plano
```php
<?php
$plan = $wirecardApi->plans->activate('plan101');
echo $plan->status; // ACTIVE
```

#### Desativar Plano
```php
<?php
$plan = $wirecardApi->plans->inactivate('plan101');
echo $plan->status; // INACTIVE
```

#### Alterar Plano
```php
<?php
$plan = $wirecardApi->plans->update([
    'name' => 'Plano Especial Atualizado',
]);
echo $plan->name; // Plano Especial Atualizado
```



## Assinantes

#### Criar Assinante
```php
<?php

// Criar assinante
$customer = $wirecardApi->customers->create([
  "code" => "cliente01",
  "email" => "nome@exemplo.com.br",
  "fullname" => "Nome Sobrenome",
  "cpf" => "22222222222",
  "phone_area_code" => "11",
  "phone_number" => "934343434",
  "birthdate_day" => "26",
  "birthdate_month" => "04",
  "birthdate_year" => "1980",
  "address" => [
    "street" => "Rua Nome da Rua",
    "number" => "100",
    "complement" => "Casa",
    "district" => "Nome do Bairro",
    "city" => "São Paulo",
    "state" => "SP",
    "country" => "BRA",
    "zipcode" => "05015010"
  ]
]);

// Cadastrar o cartão do assinante
$wirecardApi->customers->setCard(
    $customer->code,
    [
      "holder_name" => "Nome Completo",
      "number" => "4111111111111111",
      "expiration_month" => "06",
      "expiration_year" => "22"
    ]
);

// Parâmetro new_vault pode ser habilitado utilizando
// enableNewVault() ao criar o assinante.
$customer = $wirecardApi->customers
    ->enableNewVault()
    ->create([/*...*/])

// Opcionalmente customer e billing_info podem ser
// criados em uma única requisição, conforme 
// documentação da API Wirecard.
$customer = $wirecardApi->customers->create([
  "code" => "cliente02",
  "email" => "nome@exemplo.com.br",
  "fullname" => "Nome Sobrenome",
  "cpf" => "22222222222",
  "phone_area_code" => "11",
  "phone_number" => "934343434",
  "birthdate_day" => "26",
  "birthdate_month" => "04",
  "birthdate_year" => "1980",
  "address" => [
    "street" => "Rua Nome da Rua",
    "number" => "100",
    "complement" => "Casa",
    "district" => "Nome do Bairro",
    "city" => "São Paulo",
    "state" => "SP",
    "country" => "BRA",
    "zipcode" => "05015010"
  ],
  "billing_info" => [
    "credit_card" => [
      "holder_name" => "Nome Completo",
      "number" => "4111111111111111",
      "expiration_month" => "06",
      "expiration_year" => "22"
    ]
  ]
]);

echo $customer->code; // cliente02
```

#### Listar Assinantes
```php
<?php
$customers = $wirecardApi->customers->all();

foreach($customers as $customer) {
  echo $customer->code; // cliente01
}
```

#### Consultar Assinante
```php
<?php
$customer = $wirecardApi->customers->get('client01');
echo $customer->email; // nome@exemplo.com.br
```

#### Alterar Assinante
```php
<?php
$customer = $wirecardApi->customers->update([
  'name' => 'Novo nome',
]);
echo $customer->name; // Novo nome 
```

#### Atualizar Cartão do Assinante
```php
<?php
$customer = $wirecardApi->customers->setCard([
  'holder_name' => 'Nome Completo',
  'number' => '4222222222222222',
  'expiration_month' => '06',
  'expiration_year' => '22'
]);
echo $customer->billing_info->credit_card->number; // 4222222222222222
```

## Assinaturas
#### Criar Assinaturas
```php
<?php
$subscription = $wirecardApi->subscriptions->create([
  'code' => 'assinatura01',
  'amount' => '9990',
  'payment_method' => 'CREDIT_CARD',
  'plan'  => [
    'code'  => 'plano01'
  ],
  'customer'  => [
   'code'  => 'cliente01'
  ]
]);
echo $subscription->code; // assinatura01
```

Parâmetro `enableNewUser()` disponível caso customer seja informado junto com a criação da assinatura.
```php
<?php
$subscription = $wirecardApi->subscriptions->enableNewUser()->create([
  'code' => 'assinatura01',
  'amount' => '9990',
  'payment_method' => 'CREDIT_CARD',
  'plan'  => [
    'code'  => 'plano01'
  ],
  'customer'  => [
   'code'  => 'novoCLiente'
   // Informações de customer
  ]
]);
echo $subscription->code; // assinatura01
```

#### Listar Todas Assinaturas
```php
<?php
$subscriptions = $wirecardApi->subscriptions->all();

foreach($subscriptions as $subscription) {
  echo $subscription->code; // assinatura01
}
```

#### Consultar Detalhes de Uma Assinatura
```php
<?php
$subscription = $wirecardApi->subscriptions->get('assinatura01');
echo $subscription->amount; // 9990
```

#### Suspender Assinatura
...
#### Reativar Assinatura
...
#### Cancelar Assinatura
...
#### Alterar Assinatura
...
#### Alterar o método de pagamento
...
