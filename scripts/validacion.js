<<<<<<< HEAD
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("contact-form").addEventListener("submit", validarFormulario);
});

async function validarFormulario(e) {
  e.preventDefault(); // Prevenir el envío del formulario
=======
document.getElementById("contact-form").addEventListener("submit", function(event) {
  validarFormulario(event);
});
>>>>>>> dev

function validarFormulario(event) {
  const nombre = document.getElementById("nombre");
  const email = document.getElementById("email");
<<<<<<< HEAD
  const telefono = document.getElementById("celular");
  const mensaje = document.getElementById("mensaje"); 
=======
  const mensaje = document.getElementById("mensaje");
  const celular = document.getElementById("celular");

  const nombreTrimmed = nombre.value.trim();
>>>>>>> dev
  let valido = true;
  let errores = [];

<<<<<<< HEAD
  // Validación del nombre 
  const nombreLength = nombre.value.trim().length;
  if (nombreLength < 9 || nombreLength > 128) {
    errores.push("El nombre debe tener entre 9 y 128 caracteres.");
    valido = false;
  }

  // Validación del correo 
  const emailLength = email.value.length;
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (emailLength < 9 || emailLength > 128 || !emailRegex.test(email.value)) {
    errores.push("El correo electrónico debe ser válido y tener entre 9 y 128 caracteres.");
    valido = false;
  }

  // Validación del teléfono (exactamente 12 dígitos numéricos)
  if (!/^\d{12}$/.test(telefono.value)) {
    errores.push("El teléfono debe tener exactamente 12 dígitos numéricos.");
    valido = false;
  }

  if (!valido) {
    alert(errores.join("\n"));
    return;
  }

  const formData = new FormData(e.target);

  try {
    // Enviar datos al backend con fetch
    let response = await fetch("http://localhost:8000/send.php", {
      method: "POST",
      body: formData
    });

    let result = await response.json();

    if (result.status === "error") {
      alert(result.message);
    } else {
      alert(result.message);
      setTimeout(() => {
        window.location.href = "/gracias/index.html"; // Redirección a la página de agradecimiento
      }, 100); // Retraso de 100ms
    }
  } catch (error) {
    console.error("Error al enviar el formulario:", error);
    alert("Ocurrió un error, inténtalo de nuevo.");
=======
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
>>>>>>> dev
  }

  window.location.href = "gracias/index.html";
}
<<<<<<< HEAD
=======

>>>>>>> dev
