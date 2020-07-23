<?php

namespace WirecardSubscription\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Retorna todos os erros da resposta Wirecard.
     */
    public function errors()
    {
        return $this->data->errors ?? false;
    }

    /**
     * Retorna todos os alertas da resposta Wirecard.
     */
    public function alerts()
    {
        return $this->data->alerts ?? false;
    }

    /**
     * Retorna a primeira mensagem da lista de erros.
     */
    public function firstError()
    {
        $errors = $this->errors();
        if (! $errors) {
            return '';
        }

        return array_shift($errors)->description ?? '';
    }

    /**
     * Retorna a primeira mensagem da lista de alertas.
     */
    public function firstAlert()
    {
        $errors = $this->alerts();
        if (! $errors) {
            return '';
        }

        return array_shift($errors)->description ?? '';
    }
}
