<?php
// Converte encoding "X" para UTF-8
function mudarEncodingParaUtf8($texto) {
  $encodingAtual = mb_detect_encoding($texto, "auto");
  $texto = iconv($encodingAtual, 'UTF-8', $texto);
  return $texto;
}

function enviarEmailsCriarListas($email, $nome, $arqEmails, $arqNomes) {
  if ($email) {
    if (file_exists($arqEmails)) {
      $hdlrEmail = fopen($arqEmails, "a+r") or print("O arquivo não pode ser aberto.");
      $conteudoEmail = fread($hdlrEmail, filesize($arqEmails));

      if (!preg_match("/$email/i", $conteudoEmail)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE) {
          if (PATH_SEPARATOR == ";") {
            $quebraLinha = "\r\n";
          } else {
            $quebraLinha = "\n";
          }

          $destinatario = "dev@marcker.net";
          // $destinatario = "web@revistamaua.com.br";
          $assunto = "TV MAUÁ E REGIÃO - QUERO SER O PRIMEIRO";
          $nome = ucwords($nome);
          $conteudo = 
            '<p><b>Nome:</b> ' . $nome . '</p>
             <p><b>E-mail:</b> ' . $email . '</p>
             <p><b>Assunto:</b> ' . $assunto . '</p>';
             
          $headers .= "MIME-Version: 1.1" . $quebraLinha;
          $headers .= "Content-type: text/html; charset=utf-8" . $quebraLinha;
          $headers .= "From: " . $email . $quebraLinha;

          if (!mail($destinatario, $assunto, $conteudo, $headers , "-r " . $destinatario)) {
            mail($destinatario, $assunto, $conteudo, $headers);
          }

          fwrite($hdlrEmail, $email . ", ");
          fclose($hdlrEmail);

          // Adiciona nomes a lista
          if (file_exists($arqNomes)) {
            $hdlrNome = fopen($arqNomes, "a+r") or print("O arquivo não pode ser aberto.");
            fwrite($hdlrNome, mudarEncodingParaUtf8($nome) . "\n");
            fclose($hdlrNome);
          }
        }
      }
    }
  }
}

$path = '/home/marc11/public_html/hot-tv/';
criarListaEmails(
  strtolower($_GET["email"]),
  $_GET["nome"],
  $path . "lista-de-emails.txt",
  $path . "lista-de-nomes.txt"
);

?>