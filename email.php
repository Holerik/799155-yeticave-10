<?php
require_once "vendor/autoload.php";

/**
 * Отсылает информацию
 * 
 * @param string $name    Имя получателя
 * @param string $content Содержимое письма
 * @param string $email   Адрес получателя
 * 
 * @return Ничего 
 */
function Send_Message_mail($name, $content, $email) 
{
    $transport = new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl');
    $transport->setPassword('*********');
    $transport->setUsername('a_zobnin@mail.ru');
    $message = new Swift_Message('Аукцион YetiCave');
    $message->setTo([$email, $email => $name]);
    $message->setFrom(['a_zobnin@mail.ru' => 'YetiCave']);
    $message->setMaxLineLength(255);
    $message->setBody($content, 'text/html');
    $mailer = new Swift_Mailer($transport);
    $result = $mailer->send($message);
}

/**
 * Отсылает информацию
 * 
 * @param string $name    Имя получателя
 * @param string $content Содержимое письма
 * @param string $email   Адрес получателя
 * 
 * @return Ничего 
 */
function Send_message($name, $content, $email) 
{
    $transport = new Swift_SmtpTransport('phpdemo.ru', 25);
    $transport->setPassword('htmlacademy');
    $transport->setUsername('keks@phpdemo.ru');
    $message = new Swift_Message('Аукцион YetiCave');
    $message->setTo([$email, $email => $name]);
    $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);
    $message->setMaxLineLength(255);
    $message->setBody($content, 'text/html');
    $mailer = new Swift_Mailer($transport);
    $result = $mailer->send($message);
}
