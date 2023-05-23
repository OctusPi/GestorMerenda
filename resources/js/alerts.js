class Alerts
{
    inhtml = document.getElementById('msgalert')

    styles = {
        error:     'alert alert-danger',
        rededown:  'alert alert-danger',
        warning:   'alert alert-warning',
        notfound:  'alert alert-warning',
        mandatory: 'alert alert-warning',
        leastone:  'alert alert-info',
        duplici:   'alert alert-warning',
        success:   'alert alert-success'
    }

    messages = {
        error:     'Erro ao processar solicitação...',
        rededown:  'Servidor Temporáriamente Indisponível',
        warning:   'Falha ao processar solicitação!',
        notfound:  'Dados não localizados!',
        mandatory: 'Campos obrigatórios não informados!',
        leastone:  'Informe um campo de busca',
        duplici:   'Falha tentativa de duplicação de dados!',
        callback:  'Falha interna, contate o suporte!',
        success:   'Operação realizada com sucesso!'
    }

    /**
     * show alert in DOM by params parser on 6 seconds
     * @param {Object} params 
     */
    activealert(params){
        if(this.inhtml){
            scrollTo(0, 0)
            this.inhtml.innerHTML = `<div class="${this.styles[params.code ?? 'callback']}" role="alert">${this.messages[params.code ?? 'callback']} ${params.details ?? ''}</div>`;
        }
    }

    /**
     * erase alert immediately
     */
    resetalert(){
        if(this.inhtml){
            this.inhtml.innerHTML = '';
        }
    }
}