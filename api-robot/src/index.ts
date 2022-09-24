import { config } from 'dotenv'
import express from 'express'
import { join, parse } from 'path'
import routes from './routes'
(async () => {
  config({
    path: join(parse(__dirname).dir, '.env')
  })
  const app = express()
  app.use(express.json())
  app.use(routes)
  app.listen(process.env.SERVER_PORT, () => {
    console.log('SERVER RUNNING IN PORT ' + process.env.SERVER_PORT)
  })
})()
