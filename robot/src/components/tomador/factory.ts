import { Page } from 'puppeteer-core'
import IworkerData from '../../interfaces/IworkerData'
import SELECTORS from '../../selectors.json'
import { Tomador } from './Tomador'

export default async (page: Page, workerData: IworkerData) => {
  const tomador = new Tomador(page, workerData)
  const objFactory = {
    'Pesquisa Tomador': () => tomador.searchTomador(),
    'Selecione o tipo de tomador': () => tomador.selectTypeTomador(),
    'Dados Tomador': () => tomador.infoTomador(),
    'Cadastrar Tomador': () => tomador.registerTomador()
  }

  const fieldsets = await page.$$eval(SELECTORS.fieldsets_tomador.selector, elements => elements.length)
  for (let index = 1; index <= fieldsets; index++) {
    const title = await page.$eval(SELECTORS.fieldsets_tomador.title.replace(':index', index.toString()), element => element.textContent.trim())
    await objFactory[title]()
  }
}
