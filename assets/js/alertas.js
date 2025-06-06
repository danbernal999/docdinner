function mostrarAlerta(id, mensaje, tipo = 'info') {
    const colores = {
        info: 'bg-blue-100 text-blue-800',
        error: 'bg-red-100 text-red-800',
        success: 'bg-green-100 text-green-800',
        warning: 'bg-yellow-100 text-yellow-800'
    };

    const clase = colores[tipo] || colores.info;

    const html = `
        <div class="${clase} px-4 py-2 rounded mb-4 text-sm text-center">
            ${mensaje}
        </div>
    `;

    const contenedor = document.getElementById(id);
    if (contenedor) {
        contenedor.innerHTML = html;
    }
}