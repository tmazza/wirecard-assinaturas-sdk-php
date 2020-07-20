## Sobre

SDK PHP para facilitar o uso da [API de Assinaturas da Wirecard](https://dev.wirecard.com.br/v1.5).

## Uso

### Exemplo

```php
<?php
use tmazza\WirecardSubscriptions\WireacrdApi;

$api = new WirecardApi();


# Lista de planos
$api->plans->all(); 

# Criação de usuário
$api->customers->create([ ... ]); 

# Criação de assinatura
$api->subscriptions->create([ ... ]); 

# Consulta de assinatura
$api->subscriptions->get('code');

```

### Instalação
<pre>composer require tmazza/wirecard-assinaturas-sdk-php</pre>

### Credenciais

Defina as variáveis de ambiente `WIRECARD_SUBSCRIPTIONS_ENV`,  `WIRECARD_SUBSCRIPTIONS_TOKEN` e `WIRECARD_SUBSCRIPTIONS_KEY`, para especificar, respectivamente o ambiente o token e a chave da integração da Wirecard. O ambiente *default* utilizado será o de *sandbox*.

Alternativamente o ambiente e as credenciais podem ser definidas na criação da classe da API, passando os parâmetros conforme: `new WirecardApi('sandbox', 'token', 'key')`. Esses parâmetros terão precedência sob as variáveis de ambiente.


---
## API

#### ASSINATURAS

- **Planos**
    - Criar plano
    - Listar Planos
    - Consultar Plano
    - Ativar Plano
    - Desativar Plano
    - Alterar Plano

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
