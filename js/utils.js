/**
 * Gera o HTML para um checkbox dinâmico,
 * com base nos parâmetros fornecidos.
 * @param {string} label
 * @param {string} id
 * @param {string} value
 * @param {Array<string>} divClasses
 * @param {Array<string>} inputClasses
 * @param {Array<string>} labelClasses
 * @param {boolean} checked default false
 * @returns
 */
export function gerarCheckbox(
  label,
  id,
  value,
  divClasses = [],
  inputClasses = [],
  labelClasses = [],
  checked = false
) {
  const div = document.createElement("div");
  if (divClasses.length) div.classList.add(...divClasses);

  const input = document.createElement("input");
  input.type = "checkbox";
  input.id = id;
  input.value = value;
  if (inputClasses.length) input.classList.add(...inputClasses);
  if (checked) input.checked = true;

  const labelEl = document.createElement("label");
  if (labelClasses.length) labelEl.classList.add(...labelClasses);
  labelEl.setAttribute("for", id);
  labelEl.textContent = label;

  div.append(input, labelEl);
  return div;
}
