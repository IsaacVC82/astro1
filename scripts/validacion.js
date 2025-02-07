function validarFormulario(e) {
  e.preventDefault(); // Prevenir el envío del formulario

  const nombre = document.getElementById("nombre");
  const email = document.getElementById("email");
  const telefono = document.getElementById("celular");
  const mensaje = document.getElementById("mensaje"); 
  let valido = true;

  // Validación del nombre (entre 9 y 128 caracteres)
  const nombreLength = nombre.value.trim().length;
  if (nombreLength < 9 || nombreLength > 128) {
    alert("El nombre debe tener entre 9 y 128 caracteres.");
    valido = false;
  }

  // Validación del correo (entre 9 y 128 caracteres y formato válido)
  const emailLength = email.value.length;
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (emailLength < 9 || emailLength > 128 || !emailRegex.test(email.value)) {
    alert("El correo electrónico debe ser válido y tener entre 9 y 128 caracteres.");
    valido = false;
  }

  // Validación del teléfono (exactamente 12 dígitos numéricos)
  if (!/^\d{12}$/.test(telefono.value)) {
    alert("El teléfono debe tener exactamente 12 dígitos numéricos.");
    valido = false;
  }

  // Si todo es válido, redirigir a la página de agradecimiento
  if (valido) {
    window.location.href = '/gracias/index.html';
  }
}

document.getElementById('contact-form').addEventListener('submit', validarFormulario);
