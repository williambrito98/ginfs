export class ConfirmDataServico extends Error {
  constructor (message: string) {
    super(message)
    this.name = 'ConfirmDataServico'
  }
}
