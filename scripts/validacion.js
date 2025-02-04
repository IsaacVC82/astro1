function validarFormulario(event) {
    const nombre = document.getElementById("nombre");
    const email = document.getElementById("email");
    const nombreTrimmed = nombre.value.trim();
    let valido = true;
  
    // Validación del nombre (mínimo 3 caracteres)
    if (nombreTrimmed.length < 3) {
      alert("El nombre debe tener al menos 3 caracteres.");
      valido = false;
    }
  
    // Validación de solo letras y espacios
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreTrimmed)) {
      alert("El nombre solo debe contener letras y espacios, sin números ni símbolos.");
      valido = false;
    }
  
    // Validación del correo electrónico
    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!regexEmail.test(email.value)) {
      alert("Por favor, ingresa un correo electrónico válido.");
      valido = false;
    }
  
    // Si hay errores, detener el envío del formulario
    if (!valido) {
      event.preventDefault();
    }
  }
  