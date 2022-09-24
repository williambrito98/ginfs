export default class TomadorNotFound extends Error {
  constructor (message: string) {
    super(message)
    this.name = 'TomadorNotFound'
  }
}
