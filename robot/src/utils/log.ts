import { appendFileSync, existsSync, mkdirSync } from 'fs'
import { join } from 'path'

export class Log {
    private messages : Array<string> = []
    private pathLogFile : string
    private date : string
    constructor (pathLog) {
      if (!existsSync(pathLog)) mkdirSync(pathLog)
      const date = new Date()
      const year = date.getFullYear()
      const month = (date.getMonth() + 1).toString().padStart(2, '0')
      const day = date.getDate().toString().padStart(2, '0')
      const hour = date.getHours().toString().padStart(2, '0')
      const minutes = date.getMinutes()
      const seconds = date.getSeconds()
      this.date = `${year}-${month}-${day} ${hour}:${minutes}:${seconds}`
      const folderLogMonth = `${year}-${month}-${day}`
      if (!existsSync(join(join(pathLog, folderLogMonth)))) mkdirSync(join(pathLog, folderLogMonth))
      this.pathLogFile = join(pathLog, folderLogMonth, 'log.txt')
    }

    private setMessages (message: string) {
      if (typeof (message) === 'string') {
        this.messages.push(message + '|\n')
      }
    }

    public getMessages () {
      return this.messages.join('\n')
    }

    public write (...message : any) {
      if (message instanceof Array) {
        message.forEach(item => {
          console.log(item)
          if (typeof (item) === 'string') {
            this.setMessages(`${this.date} ${item}`)
            appendFileSync(this.pathLogFile, `${this.date} ${message}\n`)
          }
        })
      }
    }
}
