document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("contact-form").addEventListener("submit", validarFormulario);
});

async function validarFormulario(e) {
  e.preventDefault(); // Prevenir el envío del formulario

  const nombre = document.getElementById("nombre");
  const email = document.getElementById("email");
  const telefono = document.getElementById("celular");
  const mensaje = document.getElementById("mensaje"); 
  let valido = true;
  let errores = [];

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
    let response = await fetch("/backend/send.php", {
      method: "POST",
      body: formData
    });

    let result = await response.json();

    if (result.status === "error") {
      alert(result.message);
    } else {
      alert(result.message);
      window.location.href = "/gracias/index.html"; // Redirección a página de agradecimiento
    }
  } catch (error) {
    console.error("Error al enviar el formulario:", error);
    alert("Ocurrió un error, inténtalo de nuevo.");
  }
}
 