<?php

namespace App\Utils\Outils;

use DateTime;
use DateTimeZone;

class Outils
{
    static public function verifierUser($user, $chemin) {
        $testUser = $user;
        //Si pas l'user connecté
        if (!$testUser) {
            return $chemin;
        }
        return $testUser;
    }


    /**
     * @param string|null $format
     * @return DateTime
     */
    static public function creerDate(?string $format): DateTime
    {
        try {
            $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
            $date->format($format);
        } catch (\Exception $exception) {
            $date = null;
        }
        return $date;
    }


}