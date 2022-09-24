import { ElementHandle, Page } from 'puppeteer-core'
import Ifactory from '../../interfaces/Ifactory'
import IworkerData from '../../interfaces/IworkerData'
import SELECTORS from '../../selectors.json'
import { ElementError } from '../error/ElementError'
import TomadorNotFound from '../error/TomadorNotFound'
import { ConfirmDataTomador } from '../error/ConfirmDataTomador'

export class Tomador implements Ifactory {
  public page: Page
  public workerData: IworkerData

  constructor (page: Page, workerData: IworkerData) {
    this.page = page
    this.workerData = workerData
  }

  public async searchTomador () {
    await this.page.type(SELECTORS.tomador.inputSelector, this.workerData.tomador.cpfCnpj).catch(e => { throw new ElementError('') })
    await this.page.click(SELECTORS.tomador.buttonSelector).catch(e => { throw new ElementError('') })
    await this.page.waitForTimeout(1500)
    // @ts-ignore
    const modal = await this.page.$eval('#ext-comp-1011', element => element.innerText.trim().split('\n'))
    if (modal.length > 1) {
      if (modal[1].includes('Não foi encontrado tomador')) {
        throw new TomadorNotFound(modal[1])
      }
    }
    return true
  }

  public async selectTypeTomador () {
    // console.log('TIPO TOMADOR')
  }

  public async infoTomador () {
    // console.log('INFO TOMADOR')
  }

  public async registerTomador () {
    // console.log('CADASTRAR TOMADOR')
  }

  public static async confirmData (workerData : IworkerData, element : ElementHandle) {
    // @ts-ignore
    const cnpjTomador = await element.$eval('div.x-fieldset-bwrap > div > div:nth-child(2) > div > div > div > div:nth-child(1) input', element => element.value.replace(/\.|\/|-/gmi, '').trim())
    if (cnpjTomador !== workerData.tomador.cpfCnpj) {
      throw new ConfirmDataTomador('Não foi possivel selecionar o tomador corretamente')
    }
    return true
  }
}
