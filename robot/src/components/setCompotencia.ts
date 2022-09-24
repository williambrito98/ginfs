import { Page } from 'puppeteer-core'

export default async (page: Page, date: string) => {
  await page.evaluate((day, month, year) => {
    // @ts-ignore
    document.querySelector('#ext-gen983').value = day
    // @ts-ignore
    document.querySelector('#ext-gen985').value = month
    // @ts-ignore
    document.querySelector('#ext-gen987').value = year
  }, ...date.split('-'))
}
