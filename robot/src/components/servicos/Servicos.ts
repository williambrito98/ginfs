import { Page } from 'puppeteer-core'
import Ifactory from '../../interfaces/Ifactory'
import IworkerData from '../../interfaces/IworkerData'
import SELECTORS from '../../selectors.json'
import { ElementError } from '../error/ElementError'
import { formatDate } from '../helpers/date'

export class Servicos implements Ifactory {
  public page: Page
  public workerData: IworkerData

  constructor (page: Page, workerData: IworkerData) {
    this.page = page
    this.workerData = workerData
    this.workerData.dataEmissao = formatDate(this.workerData.dataEmissao, 'dd-MM-YY', 'pt-br')
  }

  public async setCompetencia () {
    const keys = Object.keys(SELECTORS.competencia).filter(item => item !== 'select')
    for (let i = 0; i < keys.length; i++) {
      await this.page.click(SELECTORS.competencia[keys[i]].input).catch(e => { throw new ElementError('') })
      await this.page.waitForTimeout(1500)
      const select = await this.page.$$(SELECTORS.competencia.select).catch(e => { throw new ElementError('') })
      const lengthOptions = await select[SELECTORS.competencia[keys[i]].index].$$eval('div:first-child div', element => element.length).catch(e => { throw new ElementError('') })
      for (let index = 1; index <= lengthOptions; index++) {
        const option = await select[SELECTORS.competencia[keys[i]].index].$eval(`div:first-child div:nth-child(${index})`, element => element.textContent.trim()).catch(e => { throw new ElementError('') })
        if (option.trim().toLocaleLowerCase() === this.workerData.dataEmissao.split('-')[SELECTORS.competencia[keys[i]].index].trim().toLocaleLowerCase()) {
          await this.page.evaluate((selectParent, indice, selectorChild) => {
            document.querySelectorAll(selectParent)[indice].querySelector(selectorChild).click()
          }, SELECTORS.competencia.select, SELECTORS.competencia[keys[i]].index, `div:first-child div:nth-child(${index})`)
          break
        }
      }
    }
  }

  public async setServico () {
    await this.page.focus(SELECTORS.discriminacao_servicos.btn_list_services)
    await this.page.keyboard.sendCharacter(String.fromCharCode(13))
    await this.page.keyboard.press('Enter')
    await this.page.waitForSelector(SELECTORS.discriminacao_servicos.modal.inputSearch)
    await this.page.waitForTimeout(1500)
    await this.page.type(SELECTORS.discriminacao_servicos.modal.inputSearch, this.formatCodigoServico(this.workerData.servico.codigo))
    await this.page.click(SELECTORS.discriminacao_servicos.modal.buttonSearch)
    await this.page.waitForTimeout(2500)

    const optionsServicos = await this.page.$$eval(SELECTORS.discriminacao_servicos.modal.optionsServicos, element => element.length)
    for (let index = 1; index <= optionsServicos; index++) {
      const [codigo, atividade] = await this.page.$eval(SELECTORS.discriminacao_servicos.modal.codigoAndAtividade.replace(':index', index.toString()), element => element.textContent.trim().split('/'))
      if (codigo.trim() === this.formatCodigoServico(this.workerData.servico.codigo) && atividade.trim() === this.workerData.servico.atividade) {
        await this.page.evaluate((selectorScroll, selectorElement) => {
          // @ts-ignore
          const offsetScroll = $(selectorScroll).offset() // eslint-disable-line
          const offsetElement = $(selectorElement).offset() // eslint-disable-line
          document.querySelector(selectorScroll).scroll(0, offsetElement.top - offsetScroll.top)
        }, SELECTORS.discriminacao_servicos.modal.divScroll, SELECTORS.discriminacao_servicos.modal.codigoAndAtividade.replace(':index', index.toString())).catch(e => { throw new ElementError('') })
        const coordinates = await (await this.page.$(SELECTORS.discriminacao_servicos.modal.codigoAndAtividade.replace(':index', index.toString()))).boundingBox().catch(e => { throw new ElementError('') })
        await this.page.mouse.click(coordinates.x, coordinates.y, { clickCount: 2, button: 'left' })
        break
      }
    }

    await this.page.waitForTimeout(2000)
    await this.page.type(SELECTORS.discriminacao_servicos.aliquota, this.workerData.aliquota).catch(e => { throw new ElementError('') })
    await this.page.type(SELECTORS.discriminacao_servicos.descricao, this.workerData.servico.descricao).catch(e => { throw new ElementError('') })
  }

  public async setValores () {
    await this.page.type(SELECTORS.valores.inputValorServico, this.workerData.valor).catch(e => { throw new ElementError('') })
  }

  private formatCodigoServico (codigo: string) {
    return `${codigo.slice(0, codigo.length - 2)}.${codigo.slice(-2)}`
  }
}
