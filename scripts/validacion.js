function validarFormulario(e) {
  e.preventDefault();  // Prevenir el comportamiento por defecto del formulario

  const nombre = document.getElementById("nombre");
  const email = document.getElementById("email");
  const telefono = document.getElementById("celular");
  const mensaje = document.getElementById("mensaje");
  let valido = true;

  // Validación del nombre
  if (nombre.value.trim().length < 3) {
    alert("El nombre debe tener al menos 3 caracteres.");
    valido = false;
  }

  // Validación del correo
  if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(email.value)) {
    alert("Correo electrónico inválido.");
    valido = false;
  }

  // Validación del teléfono
  if (!/^\d{10}$/.test(telefono.value)) {
    alert("El teléfono debe tener 10 dígitos.");
    valido = false;
  }

  // Validación del mensaje
  if (mensaje.value.trim().length < 10) {
    alert("El mensaje debe tener al menos 10 caracteres.");
    valido = false;
  }

  // Si la validación es exitosa, redirige a la página de gracias
  if (valido) {
    window.location.href = '/gracias/'; 
  }
}

document.getElementById('contact-form').addEventListener('submit', validarFormulario);
