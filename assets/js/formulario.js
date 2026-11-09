/* Validación del lado del cliente: avisa antes de enviar. El servidor vuelve a validar todo. */
const formulario = document.getElementById('form-incidencia');

if (formulario) {
    formulario.setAttribute('novalidate', '');
    const descripcion = document.getElementById('descripcion');
    const contador = document.getElementById('contador');

    const marcar = (campo) => {
        if (campo.type !== 'radio' && campo.tagName !== 'SELECT' && campo.id !== 'descripcion') {
            campo.value = campo.value.trim();
        }
        const valido = campo.checkValidity() && (campo.id !== 'descripcion' || campo.value.trim().length >= 10);
        const nombre = campo.name;
        const salida = document.getElementById(`err-${nombre}`);
        const destino = campo.type === 'radio' ? campo.closest('.opciones') : campo;
        salida.textContent = valido ? '' : campo.dataset.mensaje;
        destino.toggleAttribute('aria-invalid', !valido);
        return valido;
    };

    const actualizarContador = () => {
        contador.textContent = `${descripcion.value.length} de 500 caracteres.`;
    };
    descripcion.addEventListener('input', actualizarContador);
    actualizarContador();

    formulario.querySelectorAll('input:not([type=hidden]), select, textarea').forEach((campo) => {
        campo.addEventListener('change', () => marcar(campo));
    });

    formulario.addEventListener('submit', (evento) => {
        const campos = [...formulario.querySelectorAll('input:not([type=hidden]):not([type=radio]), select, textarea')];
        campos.push(formulario.querySelector('input[name=prioridad]'));
        const invalidos = campos.filter((campo) => !marcar(campo));
        if (invalidos.length) {
            evento.preventDefault();
            invalidos[0].focus();
        }
    });
}
