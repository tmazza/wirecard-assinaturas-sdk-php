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

#### ASSINATURAS

- **Planos**
    - [Criar plano](#criar-plano)
    - [Listar Planos](#listar-planos)
    - [Consultar Plano](#consultar-plano)
    - [Ativar Plano](#ativar-plano)
    - [Desativar Plano](#desativar-plano)
    - [Alterar Plano](#alterar-plano)

- **Assinantes**
    - Criar Assinante
    - Listar Assinantes
    - Consultar Assinante
    - Alterar Assinante
    - Atualizar Cartão do Assinante

- **Assinaturas**
    - Criar Assinaturas
    - Listar Todas Assinaturas
    - Consultar Detalhes de Uma Assinatura
    - Suspender Assinatura
    - Reativar Assinatura
    - Cancelar Assinatura
    - Alterar Assinatura
    - Alterar o método de pagamento

#### PAGAMENTOS
- **Faturas**
    - get Listar Todas as Faturas de Uma Assinatura
    - get Consultar Detalhes de Uma Fatura

- **Pagamentos**
    - get Listar Todos os Pagamentos de Uma Fatura
    - get Consultar Detalhes de Um Pagamento da Assinatura

- **Cupons**
    - post Criar Cupom
    - put Associar um Cupom a Assinatura Existente
    - post Associar um Cupom a uma Nova Assinatura
    - get Consultar Cupom
    - get Listar Todos os Cupons
    - put Ativar e Inativar Cupons
    - delete Excluir Cupom de uma Assinatura

- **Retentativas**
    - post Retentativa de pagamento de uma fatura
    - post Gerar um novo boleto para uma fatura
    - post Criar Regras de Retentativas Automáticas
    
#### NOTIFICAÇÕES
- **Preferências de notificação**
    - post Criar Preferência de Notificação (webhook)



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