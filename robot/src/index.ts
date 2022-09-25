import CreateBrowser from './CreateBrowser/CreateBrowser'
import { workerData } from 'worker_threads'
import SELECTORS from './selectors.json'
import login from './components/login'
import factoryTomador from './components/tomador/factory'
import factoryServicos from './components/servicos/factory'
import factoryResumo from './components/resumo/factory'
import { ElementError } from './components/error/ElementError'
import { v4 } from 'uuid'
import { join, parse } from 'path'
import { existsSync, mkdirSync } from 'fs'
import { EmissaoNotaError } from './components/error/EmissaoNotaError'
import sendNota from './components/sendNota'
import { config } from 'dotenv'
import ServiceNotFound from './components/error/ServiceNotFound'
import TomadorNotFound from './components/error/TomadorNotFound'
import LoginError from './components/error/LoginError'
import { ConfirmDataTomador } from './components/error/ConfirmDataTomador'
import { ConfirmValores } from './components/error/ConfirmValores'
import { ConfirmDataServico } from './components/error/ConfirmDataServico'
import { Log } from './utils/log'
// import IworkerData from './interfaces/IworkerData'

let COUNT = 1

const log = new Log(join(process.env.PWD, 'log'))

async function main () {
  config({ path: join(parse(__dirname).dir, '.env') })
  const newBrowser = new CreateBrowser()
  const { page, browser } = await newBrowser.init()

  log.write(workerData)
  log.write('INICIANDO ROBO')

  try {
    await page.goto(workerData.urlCidade, { waitUntil: 'networkidle0' })
    await page.waitForSelector('table.imagemPanel01 img')
    await page.waitForTimeout(2000)
    await page.click('table.imagemPanel01 img').catch(e => { throw new ElementError('') })
    if (!(await login(page, workerData.identificacao, workerData.password))) {
      throw new LoginError('Usuário ou senha incorreto')
    }
    log.write('LOGADO')
    await page.waitForSelector(SELECTORS.btn_emitir).catch(e => { throw new ElementError('') })
    await page.click(SELECTORS.btn_emitir).catch(e => { throw new ElementError('') })
    log.write('REGISTRANDO DADOS DO TOMADOR')
    await factoryTomador(page, workerData)
    await page.click(SELECTORS.btn_next).catch(e => { throw new ElementError('') })
    log.write('REGISTRANDO DADOS DO SERVIÇO, VALOR E ALIQUOTA')
    await factoryServicos(page, workerData)
    const textButtonNextStep = await page.$eval(SELECTORS.btn_next_step, element => element.textContent.trim())
    if (textButtonNextStep !== 'Emitir Nfse') {
      await page.click(SELECTORS.btn_next_step).catch(e => '')
      await page.waitForTimeout(5000)
      const modalNotaEmitida = await page.$eval('#ext-comp-1011 > div:nth-child(2) > div > div > div > div > div > div:nth-child(2)', element => element.textContent.trim()).catch(e => 'ok')
      if (modalNotaEmitida.includes('Não foi possível enviar a nota')) {
        throw new EmissaoNotaError(modalNotaEmitida)
      }

      await factoryResumo(page, workerData)
      await page.click(SELECTORS.btn_emitir_nota).catch(e => '')
      await page.waitForTimeout(5000)
    }
    await page.click(SELECTORS.btn_next_step).catch(e => '')
    await page.waitForTimeout(5000)
    // @ts-ignore
    const modalNotaEmitida = await page.$eval('#ext-comp-1011', element => element.innerText.trim().split('\n'))
    if (!modalNotaEmitida[0].includes('Nota enviada com sucesso')) {
      throw new EmissaoNotaError('Erro ao emitir Nota Fiscal')
    }

    if (!modalNotaEmitida[1].includes('Número da nota')) {
      throw new EmissaoNotaError('Erro ao obter numero da nota fiscal')
    }

    if (!modalNotaEmitida[2].includes('Código Verificação')) {
      throw new EmissaoNotaError('Erro ao obter numero da nota fiscal')
    }

    const numeroNota = modalNotaEmitida[1].split(':')[1]
    const codVerificacao = modalNotaEmitida[2].split(':')[1]
    log.write('Numero da nota: ' + numeroNota, 'Codigo de verificação: ' + codVerificacao)
    const tokenPath = v4()
    const PATHDOWNLOAD = join(join(process.env.pathDownload, workerData.userID.trim(), numeroNota.trim(), tokenPath.trim()))
    !existsSync(PATHDOWNLOAD) ? mkdirSync(PATHDOWNLOAD, { recursive: true }) : '' // eslint-disable-line
    await newBrowser.setLocalDownloadFiles(page, join(PATHDOWNLOAD))
    await page.click(SELECTORS.modal_button_ok)
    await page.waitForTimeout(4000)
    await page.click(SELECTORS.modal_button_ok)
    await page.waitForTimeout(2500)

    const page2 = await (await browser.pages()).find(item => {
      return item.url().includes('consultarNota')
    })
    await page2.waitForTimeout(3000)
    await page2.waitForSelector(SELECTORS.download_pdf)
    await page2.waitForTimeout(1500)
    log.write('BAIXANDO NOTA')
    await page2.click(SELECTORS.download_pdf)
    await newBrowser.waitForDownload(PATHDOWNLOAD)
    log.write('NOTA BAIXADA')
    await newBrowser.closeAll()
    await sendNota({ numeroNota: numeroNota, statusNota: 1, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
    return true
  } catch (e) {
    log.write(e)
    await newBrowser.closeAll()
    if (e instanceof ElementError) {
      return false
    }

    if (e instanceof EmissaoNotaError) {
      log.write(e.message)
      await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
      return true
    }

    if (e instanceof ServiceNotFound) {
      log.write(e.message)
      await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
      return true
    }

    if (e instanceof TomadorNotFound) {
      await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
      log.write(e.message)
      return true
    }
    if (e instanceof LoginError) {
      log.write(e.message)
      await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
      return true
    }

    if (e instanceof ConfirmDataTomador) {
      log.write(e.message)
      await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
      return true
    }

    if (e instanceof ConfirmValores) {
      log.write(e.message)
      await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
      return true
    }

    if (e instanceof ConfirmDataServico) {
      log.write(e.message)
      await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
      return true
    }
    return false
  }
}

(async () => {
  do {
    const run = await main()
    if (!run) {
      if (COUNT === 10) {
        await sendNota({ numeroNota: '', statusNota: 4, notaID: workerData.notaID, statusMessages: log.getMessages() }, workerData.url)
        break
      } else {
        COUNT++
      }
    } else {
      break
    }
  } while (COUNT !== 10)

  process.exit()
})()
