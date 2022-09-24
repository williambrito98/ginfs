import { Page } from 'puppeteer-core'
import Ifactory from '../../interfaces/Ifactory'
import IworkerData from '../../interfaces/IworkerData'
import SELECTORS from '../../selectors.json'
import { ElementError } from '../error/ElementError'

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
}
