import { ElementHandle, Page } from 'puppeteer-core'
import Ifactory from '../../interfaces/Ifactory'
import IworkerData from '../../interfaces/IworkerData'
import SELECTORS from '../../selectors.json'
import { ElementError } from '../error/ElementError'
import ServiceNotFound from '../error/ServiceNotFound'
import { ConfirmDataServico } from '../error/ConfirmDataServico'
import { ConfirmValores } from '../error/ConfirmValores'
// import { formatDate } from '../helpers/date'

export class Servicos implements Ifactory {
    public page: Page
    public workerData: IworkerData

    constructor (page: Page, workerData: IworkerData) {
      this.page = page
      this.workerData = workerData
      // this.workerData.dataEmissao = formatDate(this.workerData.dataEmissao, 'dd-MM-YY', 'pt-br')
    }

    public async setCompetencia () {
      const keys = Object.keys(SELECTORS.competencia).filter(item => item !== 'select')
      for (let i = keys.length - 1; i >= 0; i--) {
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
      if (!(await this.setServicoNotListed())) {
        if (!(await this.setServicoListed())) {
          throw new ServiceNotFound('Serviço não encontrado')
        }
      }

      await this.page.waitForTimeout(2000)
      await this.page.focus(SELECTORS.discriminacao_servicos.descricao)
      await this.page.type(SELECTORS.discriminacao_servicos.descricao, this.workerData.servico.descricao).catch(e => { throw new ElementError('') })

      await this.page.waitForTimeout(2000)
      await this.page.evaluate((selector) => {
        const inputAliquota = document.querySelector(selector)
        inputAliquota.removeAttribute('readonly')
        inputAliquota.removeAttribute('disable')
      }, SELECTORS.discriminacao_servicos.aliquota)
      await this.page.focus(SELECTORS.discriminacao_servicos.aliquota)

      await this.page.type(SELECTORS.discriminacao_servicos.aliquota, this.workerData.aliquota).catch(e => { throw new ElementError('') })

      return true
    }

    private async setServicoListed () {
      await this.page.focus(SELECTORS.discriminacao_servicos.btn_list_services)
      await this.page.keyboard.sendCharacter(String.fromCharCode(13))
      await this.page.keyboard.press('Enter')
      await this.page.waitForSelector(SELECTORS.discriminacao_servicos.modal.inputSearch)
      await this.page.waitForTimeout(2500)
      await this.page.type(SELECTORS.discriminacao_servicos.modal.inputSearch, this.formatCodigoServico(this.workerData.servico.codigo))
      await this.page.click(SELECTORS.discriminacao_servicos.modal.buttonSearch)
      await this.page.waitForTimeout(2500)

      const optionsServicos = await this.page.$$eval(SELECTORS.discriminacao_servicos.modal.optionsServicos, element => element.length)
      for (let index = 1; index <= optionsServicos; index++) {
        const [codigo, atividade] = await this.page.$eval(SELECTORS.discriminacao_servicos.modal.codigoAndAtividade.replace(':index', index.toString()), element => element.textContent.trim().split('/'))
        if (codigo.trim() === this.formatCodigoServico(this.workerData.servico.codigo) && atividade.trim() === this.workerData.servico.atividade) {
          await this.page.evaluate((selectorScroll, selectorElement) => {
            const el = document.querySelector(selectorScroll)
            if (el.scrollHeight > el.clientHeight) {
              // @ts-ignore
                        const offsetScroll = $(selectorScroll).offset() // eslint-disable-line
                        const offsetElement = $(selectorElement).offset() // eslint-disable-line
              document.querySelector(selectorScroll).scroll(0, offsetElement.top - offsetScroll.top)
            }
          }, SELECTORS.discriminacao_servicos.modal.divScroll, SELECTORS.discriminacao_servicos.modal.codigoAndAtividade.replace(':index', index.toString())).catch(e => { throw new ElementError('') })
          const coordinates = await (await this.page.$(SELECTORS.discriminacao_servicos.modal.codigoAndAtividade.replace(':index', index.toString()))).boundingBox().catch(e => { throw new ElementError('') })
          await this.page.mouse.click(coordinates.x, coordinates.y, { clickCount: 2, button: 'left' })
          return true
        }
      }

      return false
    }

    private async setServicoNotListed () {
      await this.page.click(SELECTORS.fieldsets_servicos.servicos_not_listed, { clickCount: 10 })
      await this.page.waitForTimeout(3000)
      const boxServicos = await this.page.$$(SELECTORS.fieldsets_servicos.box_services_not_listed)
      const numServicos = await boxServicos[3].$$eval('div > div > div', element => element.length)
      for (let index = 1; index <= numServicos; index++) {
        const codServicoAndAtividade = await boxServicos[3].$eval(`div > div > div:nth-child(${index})`, element => element.textContent.trim().replace(/\./gmi, '').split('/'))

        if (codServicoAndAtividade[0] === '') {
          return false
        }
        if (codServicoAndAtividade.length === 3) {
          if (this.workerData.servico.codigo === codServicoAndAtividade[0].trim() && this.workerData.servico.atividade === codServicoAndAtividade[2].trim()) {
            await (await boxServicos[3].$(`div > div > div:nth-child(${index})`)).click()
            return true
          }
        }

        if (codServicoAndAtividade.length === 2) {
          if (this.workerData.servico.codigo === codServicoAndAtividade[0].trim() && this.workerData.servico.atividade === codServicoAndAtividade[1].trim()) {
            await (await boxServicos[3].$(`div > div > div:nth-child(${index})`)).click()
            return true
          }
        }

        if (codServicoAndAtividade.length === 4) {
          if (this.workerData.servico.codigo === codServicoAndAtividade[0].trim() && this.workerData.servico.atividade === codServicoAndAtividade[2].trim()) {
            await (await boxServicos[3].$(`div > div > div:nth-child(${index})`)).click()
            return true
          }
        }
      }

      return false
    }

    public static async confirmData (workerData: IworkerData, element: ElementHandle) {
      // @ts-ignore
      let competencia = await element.$eval(SELECTORS.fieldsets_resumo.prestacao_servico.competencia, element => element.value)
      // const month = competencia.toLocaleString('default', { month: 'long' })
      const month = new Date(competencia).toLocaleString('pt-BR', { month: 'long' })
      competencia = competencia.split('-')
      competencia = `${competencia[0]}-${month}-${competencia[2]}`
      if (competencia.toLowerCase() === workerData.dataEmissao.toLowerCase()) {
        return true
      }

      throw new ConfirmDataServico('Erro ao informar a data de emissão')
    }

    public static async confirmDiscriminacao (workerData: IworkerData, element: ElementHandle) {
      // @ts-ignore
      let codigoServicoAtividade = (await element.$eval(SELECTORS.fieldsets_resumo.discrimicanao_servico.codigo_servico_atividade, element => element.value.replace(/(\.)|(\s+)/g, '').trim())) as String

      if (!codigoServicoAtividade.includes('/') || !codigoServicoAtividade || typeof codigoServicoAtividade !== 'string') {
        throw new ConfirmDataServico('Erro ao confirmar o codigo e/ou a atividade do servico')
      }

      const divisorLength = codigoServicoAtividade.split('').filter(item => item === '/').length

      if (divisorLength > 1) {
        const indexFirstDivisor = codigoServicoAtividade.indexOf('/')
        codigoServicoAtividade = codigoServicoAtividade.slice(indexFirstDivisor + 1)
      }

      if (codigoServicoAtividade !== `${workerData.servico.codigo.trim()}/${workerData.servico.atividade.trim()}`) {
        throw new ConfirmDataServico('Erro ao confirmar o codigo e/ou a atividade do servico')
      }

      // @ts-ignore
      const aliquota = await element.$eval(SELECTORS.fieldsets_resumo.discrimicanao_servico.aliquota, element => parseFloat(element.value))
      if (aliquota.toString() !== parseFloat(workerData.aliquota).toString()) {
        throw new ConfirmDataServico('Erro ao confirmar a aliquota')
      }

      // @ts-ignore
      const descricao = await element.$eval(SELECTORS.fieldsets_resumo.discrimicanao_servico.descricao_servico, element => element.value.trim())
      if (descricao !== workerData.servico.descricao && workerData.servico.descricao !== '') {
        throw new ConfirmDataServico('Erro ao confirmar a descrição do serviço')
      }

      return true
    }

    public static async confirmValores (workerData: IworkerData, element: ElementHandle) {
      // @ts-ignore
      const valorServico = await element.$eval(SELECTORS.fieldsets_resumo.valores.valor_servico_prestado, element => element.value.replace(/\./gmi, '').replace(',', '.').trim())
      if (valorServico !== workerData.valor) {
        throw new ConfirmValores('Erro ao confirmar o valor da nota')
      }

      return true
    }

    public async setValores () {
      await this.page.type(SELECTORS.valores.inputValorServico, this.workerData.valor).catch(e => { throw new ElementError('') })
    }

    private formatCodigoServico (codigo: string) {
      return `${codigo.slice(0, codigo.length - 2)}.${codigo.slice(-2)}`
    }
}
