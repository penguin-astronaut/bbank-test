<?php

namespace App\Core;

use JetBrains\PhpStorm\ArrayShape;

class Validator
{
    #[ArrayShape(['errors' => "array", 'success' => "array"])] static public function validate(array $rules, ?string $prefix = null): array
    {
        $result = [
            'errors' => [],
            'success' => [],
        ];

        foreach ($rules as $field => $rule) {
            $fieldName = $prefix ? $prefix . $field : $field;

            if (!isset($_REQUEST[$fieldName])) {
                $result['errors'][$fieldName] = 'Поле обязательно для заполнения';
                continue;
            }

            $value = trim($_REQUEST[$fieldName]);

            if (!preg_match($rule['pattern'], $value)) {
                $result['errors'][$fieldName] = $rule['message'];
                continue;
            }

            if (isset($rule['callback']) && !$rule['callback']($value)) {
                $result['errors'][$fieldName] = $rule['message'];
                continue;
            }

            $result['success'][$field] = $value;
        }

        return $result;
    }
}