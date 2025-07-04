  const incluirIVA = document.getElementById('incluir_iva');
  const ivaSection = document.getElementById('iva-section');
  const tasaIVA = document.getElementById('tasa_iva');
  const inputMonto = document.getElementById('monto');
  const ivaEstimado = document.getElementById('iva_estimado');
  const valorSinIVA = document.getElementById('valor_sin_iva');

  function actualizarIVA() {
    const monto = parseFloat(inputMonto.value) || 0;
    const tasa = parseFloat(tasaIVA.value) || 0;
    const iva = monto - (monto / (1 + tasa / 100));
    const sinIVA = monto - iva;

    ivaEstimado.textContent = `$${iva.toFixed(2)}`;
    valorSinIVA.textContent = `$${sinIVA.toFixed(2)}`;
  }

  incluirIVA.addEventListener('change', () => {
    ivaSection.classList.toggle('hidden', !incluirIVA.checked);
    if (!incluirIVA.checked) {
      ivaEstimado.textContent = '$0.00';
      valorSinIVA.textContent = '$0.00';
    } else {
      actualizarIVA();
    }
  });

  tasaIVA.addEventListener('change', actualizarIVA);
  inputMonto.addEventListener('input', () => {
    if (incluirIVA.checked) actualizarIVA();
  });