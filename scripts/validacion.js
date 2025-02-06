document.getElementById("contact-form").addEventListener("submit", function(event) {
  validarFormulario(event);
});

function validarFormulario(event) {
  const nombre = document.getElementById("nombre");
  const email = document.getElementById("email");
  const mensaje = document.getElementById("mensaje");
  const celular = document.getElementById("celular");

  const nombreTrimmed = nombre.value.trim();
  let valido = true;

  // Validación del nombre (mínimo 3 caracteres)
  if (nombreTrimmed.length < 3|| nombreTrimmed > 128) {
    alert("El nombre debe tener al menos 3 caracteres.");
    valido = false;
  }

  // Validación de solo letras y espacios
  if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreTrimmed)) {
    alert("El nombre solo debe contener letras y espacios, sin números ni símbolos.");
    valido = false;
  }

  // Validación del correo electrónico
  const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!regexEmail.test(email.value)&& email.value.length <128 || email.value.length > 10) {
    alert("Por favor, ingresa un correo electrónico válido.");
    valido = false;
  }

  // Validación del celular (solo números y 12 caracteres)
  const regexCelular = /^[0-9]{12}$/;
  if (!regexCelular.test(celular.value)) {
    alert("El celular debe contener exactamente 12 números.");
    valido = false;
  }

  // Si hay errores, detener el envío del formulario
  if (!valido) {
    event.preventDefault();
    return;
  }

  window.location.href = "gracias/index.html";
}

