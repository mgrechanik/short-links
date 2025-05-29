<?php

declare(strict_types=1);

namespace app\service;

use app\models\ShortLink;

class ShortLinkService
{
    private $length;

    public function __construct(int $length = 5)
    {
        if ($length > 10) {
            throw new \LogicException('Short urls must be no longer than 10 letters long');
        }
        $this->length = $length;
    }

    public function saveLink(ShortLink $link)
    {
        $link->scenario = ShortLink::SCENARIO_DEFAULT;
        $link->short_url = $this->generateShortLinkAlias();
        return $link->save();
    }

    /**
     * @return string
     */
    private function generateShortLinkAlias()
    {
        while (1) {
            $alias = $this->generateAlias();
            if (!ShortLink::findOne(['short_url' => $alias])) {
                return $alias;
            }
        }
    }

    /**
     * Генерируем алиас для короткой ссылки
     * @return string   Строка вида 'WrR95' (5 символов, первая обязательно заглавная буква)
     */
    private function generateAlias()
    {
        $upLetters = $this->getAllUpperEnglishLetters();
        $lowLetters = array_map('strtolower', $upLetters);
        $digits = array_map('strval', range(0, 9));
        $all = array_merge($upLetters, $lowLetters, $digits, $digits);
        shuffle($all);
        shuffle($all);
        $count = count($all);
        for ($i = 0; $i < $count; $i++) {
            if (in_array($all[$i], $upLetters, true)) {
                return implode('', array_slice($all, $i, $this->length));
            }
        }

    }

    /**
     * Получить массив из заглавных английских букв
     * @return array
     */
    private function getAllUpperEnglishLetters()
    {
        $res = [];
        for ($i = ord('A'); $i <= ord('Z'); $i++) {
            $res[] = chr($i);
        }
        return $res;

    }
}
