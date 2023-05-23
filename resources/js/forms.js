class Forms
{
    constructor(){
        this.utils  = new Utils()
        this.alerts = new Alerts()
    }

    /**
     * Prevent normal submit forms in system
     */
    prevsub() {
        const forms = [...document.forms]
        if(forms){
            forms.forEach(element => {
                element.addEventListener('submit', e => {
                    e.preventDefault()
                })
            })
        }
    }

    /**
     * Checks if values mandatory in form its ok
     * @param {Element} form 
     * @returns 
     */
    chkmandatory(form){
        if(form){
            const lsvalues = []
            const clfocus  = 'ocp-enfase'
            const lscheck  = [...form.querySelectorAll('.ocp-mandatory')]

            lscheck.forEach(element => {
                lsvalues.push(element.value)
                element.value ? element.classList.remove(clfocus) : element.classList.add(clfocus)
            })

            return lsvalues.every(value => value !== '')
        }
    }

    /**
     * Reset state form and restore default system values
     * @param {Element} form 
     */
    resetform(form){
        if(form){
            form.reset()
        }
    }

    /**
     * Feed form with return request in backend
     * @param {Element} form 
     * @param {JSON} json 
     */
    feedform(form, json){
        
    }

    /**
     * Triger async form proccess
     * @param {Object} params 
     */
    sendform(params){
        if(params.form){

            params.form.addEventListener('submit', e => {

                //instace local utilitary functions
                const alerts = this.alerts;

                const fproc   = params.form
                const fsearch = params.search

                //prevent envent submit and reset any alerts
                e.preventDefault()
                this.alerts.resetalert()

                //checks empts of mandatory inputs
                if(this.chkmandatory(fproc)){

                    //make data to body api fetch
                    const formData = new FormData(fproc);
                    if(fproc.dataset.reloadview){
                        //append in data params to search of reload view registers
                        const appdata = fsearch ? new FormData(fsearch) : fproc.dataset.reloadview
                        formData.append('search', appdata)
                    }

                    //params to request fetch api
                    const options = {
                        method:   fproc.method,
                        redirect: "follow",
                        mode:     "cors",
                        cache:    "no-cache",
                        body:     formData
                    }

                    //show loading animation
                    this.utils.loading(true)

                    //request promisse with fetch api -> catch errors and finally hide loading animation
                    fetch(fproc.action, options).then(res => {
                        if(res.ok){
                            //check res redirect page and follow url
                            if(res.redirected){
                                this.alerts.activealert({code:'success'})
                                window.location.href = res.url
                                return
                            }

                            //proccess json response by function in params
                            res.json().then(json => {
                                //proccess json by function
                                params.fn(json)
                                
                                //show message proccess in server side
                                alerts.activealert({code:json.status.code, details:json.status.details})
                            }).catch(error => {
                                this.alerts.activealert({code:'error', details:'Falha ao Processar Resposta'})
                                console.log(error)
                            })

                        }else{
                            this.alerts.activealert({code:'rededown'})
                            console.log(error)
                        }
                    }).catch(error => {
                        this.alerts.activealert({code:'error'})
                        console.log(error)
                    }).finally(() => {
                        this.utils.loading(false)
                    })
                   
                }else{
                    this.alerts.activealert({code:'mandatory'})
                }
            })
        }
    }

    /**
     * form register data in backend
     * @param {Object} params 
     */
    register(params){
        //instace local utilitary functions
        const alerts = this.alerts;
        const utils  = this.utils;

        //get container to inner data json
        const dataview = params.view ?? document.getElementById('dataview')
        //function to valid container and json view to inset in DOM
        params.fn = function(json){
            
            //set id entity register in form
            const idform = document.getElementById('id')
            if(idform && json.id){
                idform.value = json.id
            }

            //view registers inserts
            if(dataview && json.view){
                dataview.innerHTML = json.view
            } 
        }

        this.sendform(params)

    }
}