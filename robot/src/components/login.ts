import { Page } from 'puppeteer-core'
import CONFIG from '../selectors.json'
export default async (page: Page, user: string, password: string) => {
  await page.click(CONFIG.login.btn_forma_acesso_cnpj)
  await page.waitForTimeout(2500)
  await page.type(CONFIG.login.cnpj, user)
  await page.type(CONFIG.login.senha, password)
  await page.click(CONFIG.login.entrar)
  await page.waitForTimeout(2500)
  const modalError = await page.$eval('#ext-comp-1011', element => element.textContent.trim().split('.')[0].replace('Aviso', ''))
  console.log(modalError)
  if (modalError === 'Usuário ou senha não confere') {
    return false
  }
  return true
}
