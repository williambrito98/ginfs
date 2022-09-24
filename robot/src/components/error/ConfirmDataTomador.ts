export class ConfirmDataTomador extends Error {
  constructor (message: string) {
    super(message)
    this.name = 'ConfirmDataTomador'
  }
}
