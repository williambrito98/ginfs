import { Page } from 'puppeteer-core'
import IworkerData from '../../interfaces/IworkerData'
import SELECTORS from '../../selectors.json'
import { Servicos } from './Servicos'

export default async (page: Page, workerData: IworkerData) => {
  const servicos = new Servicos(page, workerData)
  const objFactory = {
    Competência: () => servicos.setCompetencia(),
    'Local da Prestação': () => '',
    'Discriminação do Serviço': () => servicos.setServico(),
    'Construção Civil': () => '',
    Valores: () => servicos.setValores(),
    'Impostos Federais': () => '',
    Totalizador: () => ''
  }

  const fieldsets = await page.$$eval(SELECTORS.fieldsets_servicos.selector, elements => elements.length)
  for (let index = 1; index <= fieldsets; index++) {
    const title = await page.$eval(SELECTORS.fieldsets_servicos.title.replace(':index', index.toString()), element => element.textContent.trim())
    console.log(title)
    if (objFactory[title]) await objFactory[title]()
  }
}
