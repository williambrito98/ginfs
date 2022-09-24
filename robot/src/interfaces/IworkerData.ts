interface ITomador {
    cpfCnpj: string
}

interface IServico {
    codigo: string
    atividade: string
    descricao: string
}

export default interface IworkerData {
    identificacao: string
    password: string
    tomador: ITomador
    dataEmissao: string
    servico: IServico
    aliquota: string
    valor: string
    userID: string
    email : string
    url: string
}
