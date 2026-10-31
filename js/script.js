function actualizarReloj() {
    const contenedorReloj = document.getElementById('reloj-contenedor');
    if (contenedorReloj) {
        const ahora = new Date();
        const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const fechaFormateada = ahora.toLocaleDateString('es-MX', opcionesFecha);
        const horaFormateada = ahora.toLocaleTimeString('es-MX');

        contenedorReloj.innerHTML = `<strong>Fecha:</strong> ${fechaFormateada} | <strong>Hora:</strong> ${horaFormateada}`;
    }
}

setInterval(actualizarReloj, 1000);
document.addEventListener('DOMContentLoaded', actualizarReloj);

function convertirDesdePesos() {
    const pesos = parseFloat(document.getElementById('monto-pesos').value);
    const resultadoUSD = document.getElementById('resultado-usd');
    const resultadoEUR = document.getElementById('resultado-eur');

    if (isNaN(pesos) || pesos <= 0) {
        resultadoUSD.innerText = "Dólares: $0.00 USD";
        resultadoEUR.innerText = "Euros: €0.00 EUR";
        return;
    }

    const tasaUSD = 19.30;
    const tasaEUR = 21.10;

    const totalUSD = (pesos / tasaUSD).toFixed(2);
    const totalEUR = (pesos / tasaEUR).toFixed(2);

    resultadoUSD.innerText = `Dólares: $${totalUSD} USD`;
    resultadoEUR.innerText = `Euros: €${totalEUR} EUR`;
}

function calcularCuadrado() {
    const num = parseFloat(document.getElementById('calc-num').value);
    const res = document.getElementById('calc-resultado');

    if (isNaN(num)) {
        res.innerText = "Por favor, ingresa un número válido.";
        res.style.color = "red";
        return;
    }

    const resultadoCuadrado = num * num;
    res.innerText = `${num} elevado al cuadrado es: ${resultadoCuadrado}`;
    res.style.color = "#004d40";
}

function evaluarCuestionario(event) {
    event.preventDefault();
    let puntos = 0;
    const totalPreguntas = 4;

    const p1 = document.querySelector('input[name="p1"]:checked');
    if (p1 && p1.value === "correcto") puntos++;

    const p2 = document.querySelector('input[name="p2"]:checked');
    if (p2 && p2.value === "correcto") puntos++;

    const p3 = document.getElementById('p3-select').value;
    if (p3 === "correcto") puntos++;

    const p4 = document.querySelector('input[name="p4"]:checked');
    if (p4 && p4.value === "correcto") puntos++;

    const res = document.getElementById('cuestionario-resultado');
    res.innerText = `Obtuviste ${puntos} de ${totalPreguntas} respuestas correctas.`;
    res.style.color = puntos === totalPreguntas ? "green" : "orange";
}

function validarFormulario(event) {
    const nombre = document.getElementById('Post-Name').value.trim();
    const comentarios = document.getElementById('comentarios').value.trim();
    const transporte = document.querySelector('input[name="radio1"]:checked');
    const lenguajes = document.querySelectorAll('input[type="checkbox"]:checked');
    const musica = document.getElementById('select_musica').value;

    if (nombre === "") {
        alert("Por favor, ingresa tu Nombre en el primer campo.");
        event.preventDefault();
        return false;
    }

    if (!transporte) {
        alert("Por favor, selecciona una opción de transporte (Coche o Moto).");
        event.preventDefault();
        return false;
    }

    if (lenguajes.length === 0) {
        alert("Por favor, selecciona al menos un lenguaje que domines.");
        event.preventDefault();
        return false;
    }

    if (musica === "") {
        alert("Por favor, selecciona tu género musical favorito.");
        event.preventDefault();
        return false;
    }

    if (comentarios.length < 5) {
        alert("Por favor, escribe un mensaje de al menos 5 caracteres en comentarios.");
        event.preventDefault();
        return false;
    }

    document.cookie = `usuario_nombre=${encodeURIComponent(nombre)}; max-age=86400; path=/`;
    alert("¡Formulario validado con éxito!");

    return true;
}