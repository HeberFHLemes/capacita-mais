export function normalizarString(valor: string): string {
  return valor
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/\s+/g, '-')
    .replace(/[^a-zA-Z0-9-]/g, '')
    .toLowerCase();
}
