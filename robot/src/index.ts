import CreateBrowser from './CreateBrowser/CreateBrowser'
import { workerData } from 'worker_threads'
import setFormaAcesso from './components/setFormaAcesso'
import SELECTORS from './selectors.json'
import login from './components/login'
import factoryTomador from './components/tomador/factory'
import factoryServicos from './components/servicos/factory'
import { ElementError } from './components/error/ElementError'
import { v4 } from 'uuid'
import { join } from 'path'
import { existsSync, mkdirSync } from 'fs'
import { EmissaoNotaError } from './components/error/EmissaoNotaError'
import sendNota from './components/sendNota'

let COUNT = 1

async function main () {
  // const dataWorker = {
  //   identificacao: '18548754000146',
  //   password: '218332CAJ7524',
  //   tomador: {
  //     cpfCnpj: '00632587000151'
  //   },
  //   dataEmissao: '30-07-2021',
  //   servico: {
  //     codigo: '2001',
  //     atividade: '523110100',
  //     descricao: 'descricao'
  //   },
  //   aliquota: '2',
  //   valor: '0.01',
  //   email: '',
  //   routeStatus: '',
  //   userID: '1'
  // }

  try {
    const newBrowser = new CreateBrowser()
    const { browser, page } = await newBrowser.init()
    await page.goto('https://santoandre.ginfes.com.br/', { waitUntil: 'networkidle0' })
    await page.click('#principal > table > tbody > tr:nth-child(2) > td > table > tbody > tr > td > table > tbody > tr > td:nth-child(1) > table > tbody > tr:nth-child(1) > td > table > tbody > tr > td:nth-child(1) > table > tbody > tr:nth-child(1) > td > table > tbody > tr > td:nth-child(1)').catch(e => { throw new ElementError('') })
    await setFormaAcesso(page, workerData.identificacao)
    const l = await login(page, workerData.identificacao, workerData.password)
    if (!l) {
      return false
    }
    await page.waitForSelector(SELECTORS.btn_emitir).catch(e => { throw new ElementError('') })
    await page.click(SELECTORS.btn_emitir).catch(e => { throw new ElementError('') })
    await factoryTomador(page, workerData)
    await page.click(SELECTORS.btn_next).catch(e => { throw new ElementError('') })
    await factoryServicos(page, workerData)
    await page.click(SELECTORS.btn_next_step).catch(e => { throw new ElementError('') })
    await page.waitForTimeout(5000)
    await page.click(SELECTORS.btn_emitir_nota).catch(e => { throw new ElementError('') })
    await page.waitForTimeout(5000)
    // @ts-ignore
    const modalNotaEmitida = await page.$eval(SELECTORS.modal_numNota_codVerificacao, element => element.innerText.trim().split('\n'))
    if (!modalNotaEmitida[0].includes('Número da nota')) {
      throw new EmissaoNotaError('')
    }

    if (!modalNotaEmitida[1].includes('Código Verificação')) {
      throw new EmissaoNotaError('')
    }
    const numeroNota = modalNotaEmitida[0].split(':')[1]
    const codVerificacao = modalNotaEmitida[1].split(':')[1]
    console.log('Numero da nota: ' + numeroNota, 'Codigo de verificação: ' + codVerificacao)
    const tokenPath = v4()
    const PATHDOWNLOAD = join(join(process.env.pathDownload, workerData.userID, numeroNota, tokenPath))
    !existsSync(PATHDOWNLOAD) ? mkdirSync(PATHDOWNLOAD, {recursive: true}) : '' // eslint-disable-line
    await newBrowser.setLocalDownloadFiles(page, join(PATHDOWNLOAD))
    await page.click(SELECTORS.modal_button_ok)
    await page.waitForTimeout(1500)
    await page.click(SELECTORS.modal_button_ok)
    await page.waitForTimeout(3000)
    const pagePDF = (await browser.pages())[2]
    await pagePDF.waitForSelector(SELECTORS.download_pdf)
    await pagePDF.waitForTimeout(1500)
    await pagePDF.click(SELECTORS.download_pdf)
    await newBrowser.waitForDownload(PATHDOWNLOAD)
    await newBrowser.closeAll(browser)
    await sendNota({ numeroNota: numeroNota, statusNota: 1 }, workerData.url)
    return true
  } catch (e) {
    if (e instanceof ElementError) {
      return false
    }

    if (e instanceof EmissaoNotaError) {
      await sendNota({ numeroNota: '', statusNota: 4 }, workerData.route)
      return true
    }
  }
}

(async () => {
  do {
    const run = await main()
    if (!run) {
      COUNT++
    } else {
      break
    }
  } while (COUNT !== 5)

  process.exit()
})()

// criar função que espero o arquivo ser baixado
// criar função que envia para o laravel as informações da nota baixada e seta o status da nota
