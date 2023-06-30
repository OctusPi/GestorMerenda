const forms  = new Forms()
const utils  = new Utils()
const mapper = new Mapper(
    "#fproc",
    "#fsearch",
    '#fdelete',
    "#btnadd",
    "#btncancel",

    //mask-elements
    ".maskcpf",
    ".maskphone",
    ".masknumb",
    ".maskdata",
    ".maskcnpj",

    //custom-elements
    ".nomodify",
    ".ocpinputimgform",
    "#ocpframeimage",
    "#reports",
    ".itemcheckreport"
    ).map

//forms rotines
forms.prevsub()
forms.search({form:mapper.fsearch})
forms.register({form:mapper.fproc, search:mapper.fsearch})
forms.eraser({form:mapper.fdelete, search:mapper.fsearch})


//utilities calls
utils.trigerview(mapper.btnadd, 'ctform')
utils.trigerview(mapper.btncancel)
utils.mask(mapper.maskcpf, 'cpf')
utils.mask(mapper.maskphone, 'phone')
utils.mask(mapper.masknumb, 'numb')
utils.mask(mapper.maskdata, 'data')
utils.mask(mapper.maskcnpj, 'cnpj')

utils.nomodify(mapper.nomodify)
utils.counttime(29)
utils.trigeractions()
utils.viewimg(mapper.ocpinputimgform, mapper.ocpframeimage)


utils.combomulti(mapper.reports, mapper.itemcheckreport)