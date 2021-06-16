<?php


namespace App\Utilities;


use phpDocumentor\Reflection\Types\Self_;

class Tools
{
    private const ID_OFFSET = 10000;

    public static function strToHtml(string $text) : string{
        return str_replace(array("\r\n", "\n", "\r"), '<br/>', $text);
    }

    public static function toExId(int $masterId, int $slaveId): int{
        return $masterId * self::ID_OFFSET + $slaveId;
    }

    public static function splitExId (int $exId): array{
        return ["masterId" => intdiv($exId, self::ID_OFFSET), "slaveId" => ($exId % Self::ID_OFFSET)];
    }

}