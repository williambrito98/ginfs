export class EmissaoNotaError extends Error {
  constructor (message: string) {
    super(message)
    this.name = 'EmissaoNotaError'
  }
}
