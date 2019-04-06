<?php

namespace app\components;


class Mailer
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public function sendEmail(string $to, string $subject, string $body): bool
    {
        $headers = 'From: Memagru Team <mg@camagru.zzz.com.ua>' . "\r\n" .
            'Reply-To: mg@camagru.zzz.com.ua' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=utf-8' . "\r\n" .
            'Content-Transfer-Encoding: quoted-printable';

        return mail($to, $subject, $body, $headers);
    }
}
