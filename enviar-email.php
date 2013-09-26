<?php
  function criarListaEmails($enderecoEmail, $arquivo) {
    if ($enderecoEmail) {
      if (file_exists($arquivo)) {
        $hdlr = fopen($arquivo, "a+r") or print("O arquivo não pode ser aberto.");
        $conteudo = fread($hdlr, filesize($arquivo));

        if (!preg_match("/$enderecoEmail/i", $conteudo)) {
          if (filter_var($enderecoEmail, FILTER_VALIDATE_EMAIL) !== FALSE) {
            if (PATH_SEPARATOR == ";") {
              $quebraLinha = "\r\n";
            } else {
              $quebraLinha = "\n";
            }

            $destinatario = "web@revistamaua.com.br";
            $assunto = "TV MAUÁ E REGIÃO - QUERO SER O PRIMEIRO";
            $nome = ucwords($_GET["nome"]);
            $conteudo = 
              '<p><b>Nome:</b> ' . $nome . '</p>
               <p><b>E-mail:</b> ' . $enderecoEmail . '</p>
               <p><b>Assunto:</b> ' . $assunto . '</p>';
               
            $headers .= "MIME-Version: 1.1" . $quebraLinha;
            $headers .= "Content-type: text/html; charset=utf-8" . $quebraLinha;
            $headers .= "From: " . $enderecoEmail . $quebraLinha;
            
            if (!mail($destinatario, $assunto, $conteudo, $headers , "-r" . $destinatario)) {
              mail($destinatario, $assunto, $conteudo, $headers);
            }

            fwrite($hdlr, $enderecoEmail . ", ");
            fclose($hdlr);
          }
        }
      }
    }
  }

  criarListaEmails(strtolower($_GET["email"]), '/home/marc11/public_html/hot-tv/lista-de-inscricoes.txt');

?>