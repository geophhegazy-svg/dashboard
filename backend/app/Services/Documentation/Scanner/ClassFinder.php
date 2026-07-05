<?php

declare(strict_types=1);

namespace App\Services\Documentation\Scanner;

class ClassFinder
{
    public function find(string $file): ?string
    {
        if (! is_file($file)) {
            return null;
        }

        $code = file_get_contents($file);

        if ($code === false) {
            return null;
        }

        $tokens = token_get_all($code);

        $namespace = '';
        $class = null;

        $count = count($tokens);

        for ($i = 0; $i < $count; $i++) {

            if (! is_array($tokens[$i])) {
                continue;
            }

            /*
             |--------------------------------------------------------
             | Namespace
             |--------------------------------------------------------
             */
            if ($tokens[$i][0] === T_NAMESPACE) {

                $namespace = '';

                $i++;

                while ($i < $count) {

                    $token = $tokens[$i];

                    if (
                        is_array($token)
                        && (
                            $token[0] === T_STRING
                            || (
                                defined('T_NAME_QUALIFIED')
                                && $token[0] === T_NAME_QUALIFIED
                            )
                            || $token[0] === T_NS_SEPARATOR
                        )
                    ) {
                        $namespace .= $token[1];
                    } elseif ($token === ';' || $token === '{') {
                        break;
                    }

                    $i++;
                }
            }

            /*
             |--------------------------------------------------------
             | Class / Interface / Trait / Enum
             |--------------------------------------------------------
             */

            $type = $tokens[$i][0];

            if (
                $type !== T_CLASS
                && $type !== T_INTERFACE
                && $type !== T_TRAIT
                && (! defined('T_ENUM') || $type !== T_ENUM)
            ) {
                continue;
            }

            $i++;

            while (
                $i < $count &&
                (
                    ! is_array($tokens[$i]) ||
                    $tokens[$i][0] !== T_STRING
                )
            ) {
                $i++;
            }

            if ($i < $count) {
                $class = $tokens[$i][1];
                break;
            }
        }

        if ($class === null) {
            return null;
        }

        return $namespace . '\\' . $class;
    }

    public function findMany(array $files): array
    {
        $classes = [];

        foreach ($files as $file) {

            $class = $this->find($file);

            if ($class !== null) {
                $classes[] = $class;
            }
        }

        return $classes;
    }
}
