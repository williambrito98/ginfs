export default class ServiceNotFound extends Error {
  constructor (message: string) {
    super(message)
    this.name = 'ServicoNotFound'
  }
}
