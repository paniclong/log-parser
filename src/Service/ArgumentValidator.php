<?php

namespace App\Service;

class ArgumentValidator
{
    /**
     * Все порядковые аргументы, которые нобходимо провалидировать для корректной работы парсера
     */
    private const ALL_ARGUMENTS = [
        Parser::ARGUMENT_STATUS_CODE,
        Parser::ARGUMENT_TRAFFIC,
        Parser::ARGUMENT_URL,
        Parser::ARGUMENT_USER_AGENT,
    ];

    /**
     * @param array $logArguments
     *
     * @return bool
     */
    public function validate(array $logArguments): bool
    {
        foreach (self::ALL_ARGUMENTS as $argument) {
            if (!isset($logArguments[$argument])) {
                return false;
            }
        }

        return true;
    }
}
