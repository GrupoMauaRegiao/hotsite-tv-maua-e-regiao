<?php
// Converte encoding "X" para UTF-8
function mudarEncodingParaUtf8($texto) {
  $encodingAtual = mb_detect_encoding($texto, "auto");
  $texto = iconv($encodingAtual, "UTF-8", $texto);
  return $texto;
}
?>