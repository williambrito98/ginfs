import { Page } from 'puppeteer-core'

export default async (page: Page, user: string, password: string) => {
  await page.type('#ext-gen29', user)
  await page.type('#ext-gen33', password)
  await page.click('#ext-gen51')
  await page.waitForTimeout(2500)
  const modalError = await page.$eval('#ext-comp-1011', element => element.textContent.trim().split('.')[0].replace('Aviso', ''))
  if (modalError === 'Usuário ou senha não confere') {
    return { status: false, error: modalError }
  }
  return true
}
