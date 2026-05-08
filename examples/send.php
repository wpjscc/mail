<?php

require __DIR__ . '/../vendor/autoload.php';

use Kodus\Mail\SMTP\Connector\SecureSocketConnector;
use Kodus\Mail\SMTP\SMTPMailService;
use Kodus\Mail\SMTP\Authenticator\LoginAuthenticator;
use Kodus\Mail\Message;
use Kodus\Mail\Address;
use function React\Async\async;

if ($argc < 4) {
    fwrite(STDERR, "Usage: php send.php <account@domain> <password> <to@address>\n");
    exit(1);
}

[, $account, $password, $toAddress] = $argv;

$clientDomain = 'localhost';
if (preg_match('/@(.+)$/', $account, $m)) {
    $clientDomain = $m[1];
}


async(function () use ($account, $password, $toAddress, $clientDomain) {
    $service = new SMTPMailService(
        new SecureSocketConnector('smtp.qq.com', 587),
        new LoginAuthenticator($account, $password),
        $clientDomain
    );

    $service->send(new Message(
        new Address($toAddress),
        new Address($account, 'from_name'),
        'Test Subject',
        '这是测试文本'
    ));

    $service->send(new Message(
        new Address($toAddress),
        new Address($account, 'from_name'),
        'Test Subject html',
        '这是html文本',
        '<html><body><h1>您的验证码是</h1><p>123456</p></body></html>'
    ));

    $service->disconnect();

    echo "Email sent\n";
})();

async(function () use ($account, $password, $toAddress, $clientDomain) {
    $service = new SMTPMailService(
        new SecureSocketConnector('smtp.qq.com', 587),
        new LoginAuthenticator($account, $password),
        $clientDomain
    );

    $service->send(new Message(
        new Address($toAddress),
        new Address($account, 'from_name'),
        'Test Subject',
        '这是测试文本'
    ));

    $service->send(new Message(
        new Address($toAddress),
        new Address($account, 'from_name'),
        'Test Subject html',
        '这是html文本',
        '<html><body><h1>您的验证码是</h1><p>123456</p></body></html>'
    ));

    $service->disconnect();

    echo "Email sent\n";
})();
