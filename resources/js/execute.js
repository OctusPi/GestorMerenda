const forms  = new Forms()
const utils  = new Utils()
const mapper = new Mapper(
    "#fproc",
    "#fsearch",

    //mask-elements
    ".maskcpf"
    ).map

//forms rotines
forms.prevsub()
forms.register({form:mapper.fproc, search:mapper.fsearch})


//mask elements
utils.mask(mapper.maskcpf, 'cpf')
utils.counttime(29)