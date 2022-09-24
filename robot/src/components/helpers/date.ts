export function formatDate (data: string, format: string, dateType: string) {
  const monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
  ]

  if (dateType === 'pt-br' && format === 'dd-MM-YY') {
    const date = new Date(data.split('-').reverse().join('-'))
    return `${data.split('-')[0]}-${monthNames[date.getMonth()]}-${data.split('-')[2]}`
  }
}
