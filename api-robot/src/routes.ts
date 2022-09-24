import { NextFunction, Request, Response, Router } from 'express'
import connection from './database/connection'
import Users from './database/interfaces/User'
import { sign, verify } from 'jsonwebtoken'
import { Worker } from 'worker_threads'
import { join } from 'path'
const router = Router()

router.post('/login', async (req, res) => {
  const conn = connection()
  const users = await conn<Users>('usuario_api').withSchema('public').where({ usuario: req.body.user, senha: req.body.password }).first()
  await conn.destroy()
  if (users) {
    const token = sign({ userID: users.id }, process.env.SECRET_API, { expiresIn: 300 })
    return res.status(200).json({ auth: true, token })
  }
  return res.send({ message: 'CLIENTE NÃO ENCONTRADO', auth: false }).end()
})

function verifyJWT (req : Request, res: Response, next: NextFunction) {
  const token = req.headers['x-access-token']
  // @ts-ignore
  verify(token, process.env.SECRET_API, (err, decoded) => {
    if (err) return res.sendStatus(401).end()
    // @ts-ignore
    req.userID = decoded.userID
    next()
  })
}

router.post('/run', verifyJWT, (req : Request, res) => {
  // @ts-ignore
  const worker = new Worker(join(process.cwd(), 'robot', 'dist', 'index.js'), { workerData: req.body })
  console.log(worker.threadId)
  return res.send({ running: true }).end()
})

export default router
