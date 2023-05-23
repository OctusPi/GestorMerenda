const forms = new Forms()
const utils = new Utils()
const map   = new Mapper(
    "#fproc",
    "#fsearch",

    //mask-elements
    ".maskcpf"
    ).map

//forms rotines
forms.prevsub()
forms.register({form:map.fproc, search:map.fsearch})


//mask elements
utils.mask(map.maskcpf, 'cpf')