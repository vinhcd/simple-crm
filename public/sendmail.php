<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;
$CLIENT_ID = '712076340395-su7jlpqgqnuveougnth2vid16likr6t2.apps.googleusercontent.com';
$CLIENT_SECRET = 'ifMW4Dkop3AWfqfZnVyLTUGY';
$REFRESH_TOKEN = '1//04CfSrJ8Al3pMCgYIARAAGAQSNwF-L9IrsKfY4KYpSq9EwXL0xB9R1A6Feul6IT6l99eiDrewQAcJ0YkPJIqWDKxMTZS2vVHUZDk';
$USER_NAME = 'baonq@neoscorp.vn';
$mail = new PHPMailer(true);
try {
    //Gmail 認証情報
    $host = 'smtp.gmail.com';
    //差出人
    $from = 'baonq@neoscorp.vn';
    $fromname = 'TimeSheet';
    //宛先
    $to1 = 'hangntc@neoscorp.vn';
    $toname1 = 'Nguyễn Thị Cẩm Hằng';
	
    $to2 = 'linhdlt@neoscorp.vn	';
    $toname2 = 'Đoàn Lê Thu Linh';
		
    //件名・本文
    $subject = urldecode($_POST["subject"]);
    $body = urldecode($_POST["body"]);
    //メール設定
    $mail->SMTPDebug = 2; //デバッグ用
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $host;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->AuthType = 'XOAUTH2';
    $provider = new Google(
        [
            'clientId' => $CLIENT_ID,
            'clientSecret' => $CLIENT_SECRET,
        ]
    );
    //Pass the OAuth provider instance to PHPMailer
    $mail->setOAuth(
        new OAuth(
            [
                'provider' => $provider,
                'clientId' => $CLIENT_ID,
                'clientSecret' => $CLIENT_SECRET,
                'refreshToken' => $REFRESH_TOKEN,
                'userName' => $USER_NAME,
            ]
        )
    );
    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";
    $mail->setFrom($from, $fromname);
    $mail->addAddress($to1, $toname1);
	$mail->addAddress($to2, $toname2);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    //メール送信
    $mail->send();
    //echo '成功'.PHP_EOL;
} catch (Exception $e) {
    //echo '失敗: ', $mail->ErrorInfo.PHP_EOL;
}