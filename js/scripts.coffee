TVMaua = TVMaua or {}
TVMaua.apps =
  enviarEmail: ->
    formulario = document.querySelector '.o-formulario form'

    if formulario
      cNome = document.querySelector '#nome'
      cEmail = document.querySelector '#email'
      msgSucesso = document.querySelector '.mensagem-sucesso'
      botao = document.querySelector '#enviar'

      botao.addEventListener 'click', (evt) ->
        xhr = new XMLHttpRequest()
        regexEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
        msg = ''

        if cNome.value isnt ''
          if cEmail.value isnt '' and cEmail.value.match(regexEmail) isnt null
            msg += 'nome=' + encodeURI(cNome.value)
            msg += '&email=' + encodeURI(cEmail.value)
            xhr.open formulario.method, formulario.action + '?' + msg, true
            xhr.send msg
            xhr.onreadystatechange = ->
              if xhr.readyState is 4 and xhr.status is 200
                formulario.style.display = 'none'
                msgSucesso.setAttribute 'class', 'mensagem-sucesso exibe'
              return
          else
            cEmail.focus()
            cEmail.setAttribute 'class', 'erro'
        else
          cNome.focus()
          cNome.setAttribute 'class', 'erro'
        evt.preventDefault()
        return
    return
Apps = TVMaua.apps
window.onload = ->
  Apps.enviarEmail()
  return