import { Page } from 'puppeteer-core'
import { ElementError } from './error/ElementError'

export default async (page: Page, identificacao: string) => {
  if (identificacao.length === 11) {
    return await page.click('#gwt-uid-1').catch(e => {
      throw new ElementError(' ')
    })
  }

  if (identificacao.length === 14) {
    return await page.click('#gwt-uid-2').catch(e => { throw new ElementError('') })
  }

  return await page.click('#gwt-uid-3').catch(e => { throw new ElementError('') })
}
