export class ElementError extends Error {
  constructor (message: string) {
    super(message)
    this.name = 'ElementError'
  }
}
