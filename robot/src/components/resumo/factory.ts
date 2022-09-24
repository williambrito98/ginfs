import { Page } from 'puppeteer-core'
import IworkerData from '../../interfaces/IworkerData'
import SELECTORS from '../../selectors.json'
import { Tomador } from '../tomador/Tomador'
import { Servicos } from '../servicos/Servicos'

export default async (page: Page, workerData: IworkerData) => {
  const objFactory = {
    'Dados do Tomador de Serviço': () => Tomador.confirmData,
    'Dados da Prestação de Serviço': () => Servicos.confirmData,
    'Discriminação do Serviço': () => Servicos.confirmDiscriminacao,
    Valores: () => Servicos.confirmValores
  }

  const fieldsets = (await page.$$(SELECTORS.fieldsets_resumo.selector))[1]
  const numFieldSets = await fieldsets.$$eval(SELECTORS.fieldsets_resumo.sub_selector, element => element.length)
  const fieldset = await fieldsets.$$(SELECTORS.fieldsets_resumo.sub_selector)
  for (let index = 0; index < numFieldSets; index++) {
    const title = await fieldset[index].$eval('legend span', element => element.textContent.trim())
    if (objFactory[title]) await objFactory[title]()(workerData, fieldset[index])
  }
}
