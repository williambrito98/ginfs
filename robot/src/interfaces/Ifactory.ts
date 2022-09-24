import { Page } from 'puppeteer-core'
import IworkerData from './IworkerData'

export default interface Ifactory {
    page: Page
    workerData : IworkerData
}
