import axios, { AxiosRequestConfig } from 'axios'
import ISendNota from '../interfaces/ISendNota'

export default async (data : ISendNota, url : string) => {
  const options = {
    method: 'POST',
    url: url,
    headers: { 'Content-Type': 'application/json' },
    data: data
  } as AxiosRequestConfig

  const response = await axios.request(options)
  return response.status
}
