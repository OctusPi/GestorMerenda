class Utils
{
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
        };

        if (elements != null) {
            elements.forEach(element => {
                IMask(element, pattners[pattner]);
            });
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
}