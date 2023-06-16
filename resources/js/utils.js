class Utils
{
    constructor(){
        this.alerts = new Alerts()
    }

    fetchget(params){
        if(params.url){
            this.loading(true)
            this.alerts.resetalert()

            const opt = {
                method: 'GET',
                redirect: 'follow',
                mode: 'cors',
                cache: 'no-cache'
            }

            fetch(params.url, opt).then(res => {
                if(res.ok){
                    res.json().then(json => {
                        //proccess json by function
                        params.fn(json)
        
                        ///show message proccess in server side
                        if(json.status){
                            this.alerts.activealert({code:json.status.code, details:json.status.details})
                        }
                    }).catch(error => {
                        this.alerts.activealert({code:'error', details:'Falha ao Processar Resposta'})
                        console.log(error)
                    })
                }else{
                    this.alerts.activealert({code:'error'})
                }
            }).catch(error => {
                this.alerts.activealert({code:'rededown'})
                console.log(error)
            }).finally(() => {
                this.loading(false)
            })
        }
    }

    /**
     * Request async HTML
     * @param {Object} params 
     */
    requesthtml(params){
        if(params.triger && params.view){
            params.triger.addEventListener('change', e => {
                params.url = params.triger.dataset.url+'&key='+e.target.value
                params.fn = function(json){
                    if(json.view){
                        params.view.innerHTML = json.view
                    }
                }

                this.fetchget(params)
            });
        }
    }

    /**
     * Masck inputs form by pattner using lib IMASK
     * @param {Array} elements 
     * @param {String} pattner 
     */
    mask(elements, pattner) {
        const pattners = {
            cpf  : { mask: '000.000.000-00' },
            cnpj : { mask: '00.000.000/0000-00' },
            phone: { mask: '(00) 0.0000-0000' },
            data : { mask: '00/00/0000' },
            cep : { mask: '00000-000' },
            nis : { mask: '000.00000.00-0' },
            inep : { mask: '0000-0000' },

            numb : {
                mask: Number,
                min: 0,
                max: 100000000000,
                radix: ".",
            },

            money: {
                mask: Number,
                min: 0,
                max: 100000000000,
                thousandsSeparator: ".",
                scale: 2,
                padFractionalZeros: true,
                normalizeZeros: true,
                radix: ",",
                mapToRadix: ["."]
            }
        }

        if (elements != null) {
            elements.forEach(element => {
                IMask(element, pattners[pattner])
            })
        }
    }

    /**
     * show loading async requests
     * @param {boolean} visible 
     */
    loading(visible = false){
        const load = document.getElementById('ocpload')
        if(load){
            if(visible){
                load.classList.remove('ocp-hidden')
                this.disableall()
            }else{
                load.classList.add('ocp-hidden')
                this.disableall(false)
            }
        }
    }
    
    /**
     * Disable inputs by proccess async request
     * @param {boolean} active 
     */
    disableall(active = true){
        const elements = [...document.querySelectorAll('input,select,button')]
        if(elements){
            elements.forEach(e => {
                active ? e.setAttribute('disabled', true) : e.removeAttribute('disabled')
            })
        }
    }

    /**
     * Show regressive count to end active session time
     * @param {Number} minutes 
     * @param {Element} contenttime 
     */
    counttime(minutes, contenttime){
        const viewtime = contenttime ?? document.getElementById('sessiontime')
        if(viewtime){
            let seconds = 59
            setInterval(function(){
                seconds--
                if(seconds == 0){
                    seconds = 59
					minutes--
                }
                    viewtime.innerHTML = 
					minutes >= 0 ? minutes.toString().padStart(2, '0')+':'+seconds.toString().padStart(2, '0') : '00:00'
            }, 1000)
        }
    }

    /**
     * Change visibility zones in app
     * @param {String} view 
     * @param {Element|null} elform 
     * @param {Element|null} elpage 
     */
    changeview(viewmode, elform = null, elpage = null){
        const ctform   = elform ?? document.getElementById('pageform')
        const ctpage   = elpage ?? document.getElementById('pagelist')

        if(ctform && ctpage)
        {
            if(viewmode === 'ctform'){
                ctform.classList.remove('ocp-hidden')
                ctpage.classList.add('ocp-hidden')

                const forms  = new Forms()
                const form = ctform.querySelector('form')
                if(form){
                    forms.resetform(form)
                }
                
            }else{
                ctform.classList.add('ocp-hidden')
                ctpage.classList.remove('ocp-hidden')
            }
        }
    }

    /**
     * 
     * @param {Element} eltriger 
     * @param {String} viewmode 
     * @param {Element|null} elform 
     * @param {Element|null} elpage 
     */
    trigerview(eltriger, viewmode, elform = null, elpage = null){
        if(eltriger){
            eltriger.addEventListener('click', e => {
                this.changeview(viewmode, elform, elpage)
            })
        }
    }

    trigeractions(){
        document.addEventListener('click', e => {
            const edit  = e.target.matches('[data-edit]')
            const delet = e.target.matches('[data-delet]')

            if(edit){
                const form   = document.getElementById('fproc')
                const params = {
                    url:e.target.dataset.edit,
                    fn : json => {
                        const utils = new Utils()
                        const forms = new Forms()

                        if(form && json){
                            utils.changeview('ctform')
                            forms.feedform(form, json)
                        }
                    }
                }
                this.fetchget(params)
            }

            if(delet){
                const field = document.getElementById('iddelete')
                const iddel = e.target.dataset.delet
                if(field && iddel){
                    field.value = iddel
                }
            }
        })
    }

    /**
     * Generate unique code to input html
     * @param {Array} fields 
     */
    setcode(fields) {
        const letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
        const digits  = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']

        const size = 14
        let code   = ''

        for (let i = 0; i < size; i++) {
            let matriz = (i > 0 && i % 2 === 0) ? digits : letters
            let key    = Math.floor(Math.random() * matriz.length)
            code      += matriz[key]
        }

        if (fields !== null) {
            fields.forEach(element => {
                element.value = code
            })
        }
    }

    /**
     * Bloq modyfi content field html imput
     * @param {Array} fields 
     */
    nomodify(fields){
        if(fields !== null)
        {
            fields.forEach(e => {
                e.addEventListener('keydown', ev => {
                    ev.preventDefault()
                })
                e.addEventListener('keypress', ev => {
                    ev.preventDefault()
                })
            })
        }
    }

    /**
     * Show img preview after upload file
     * @param {Array} fields 
     * @param {Element} frame 
     */
    viewimg(fields, frame) {
        if (fields && frame) {
            fields.forEach(element => {
                element.addEventListener('change', e => {
                    const input = e.target;
                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = readfile => {
                            frame.innerHTML = `<img src="${readfile.target.result}" 
                            alt="" class="ocp-picture-imgform mx-auto"/>`;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });
            });
        }
    }
}