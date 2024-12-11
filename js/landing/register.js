const formRegister = document.querySelector(".form-register");
const inputUser = document.querySelector('.form-register input[type="text"]');
const inputPass = document.querySelector('.form-register input[type="password"]');
const inputEmail = document.querySelector('.form-register input[type="email"]');
const inputPhone = document.querySelector('.form-register input[type="tel"]');
const alertaError = document.querySelector(".form-register .alerta-error");
const alertaExito = document.querySelector(".form-register .alerta-exito");
const alertSuccess = document.getElementsByClassName("alertSuccess");

// Expresiones regulares
const userNameRegex = /^[a-zA-Z0-9\_\-]{4,16}$/;
const emailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
const passwordRegex = /^.{4,12}$/;
const phoneRegex = /^\d{9}$/;

// Definimos los campos y reglas
const campos = [
    {
        regex: userNameRegex,
        campo: inputUser,
        mensaje: "El usuario debe tener entre 4 y 16 caracteres, y puede incluir letras, números y guiones bajos."
    },
    {
        regex: emailRegex,
        campo: inputEmail,
        mensaje: "El correo debe ser válido, por ejemplo: usuario@dominio.com."
    },
    {
        regex: passwordRegex,
        campo: inputPass,
        mensaje: "La contraseña debe tener entre 4 y 12 caracteres."
    },
    {
        regex: phoneRegex,
        campo: inputPhone,
        mensaje: "El número de teléfono debe tener exactamente 9 dígitos."
    }
];


setTimeout(() => {
    for (let item of alertSuccess) {
        item.classList.remove("alertSuccess");
        item.classList.toggle("alertSuccess-hide");
    }
}, 4000);

// Limpia las clases de error en los campos
campos.forEach(({ campo }) => {
    campo.parentElement.classList.remove("error");
});


// Validar campos dinámicamente
function validarTodosLosCampos() {
    let valido = true;

    campos.forEach(({ regex, campo, mensaje }) => {
        if (!regex.test(campo.value)) {
            mostrarAlerta(campo.parentElement.parentElement, mensaje);
            campo.parentElement.classList.add("error");
            valido = false;
        } else {
            eliminarAlerta(campo.parentElement.parentElement);
            campo.parentElement.classList.remove("error");
        }
    });

    return valido;
}

// Eventos para validar en tiempo real
campos.forEach(({ regex, campo, mensaje }) => {
    campo.addEventListener("input", () => {
        if (!regex.test(campo.value)) {
            mostrarAlerta(campo.parentElement.parentElement, mensaje);
            campo.parentElement.classList.add("error");
        } else {
            eliminarAlerta(campo.parentElement.parentElement);
            campo.parentElement.classList.remove("error");
        }
    });
});

// Evento para manejar el envío del formulario
formRegister.addEventListener("submit", (e) => {
    // e.preventDefault(); // Evita que el formulario se envíe si hay errores

    // if (validarTodosLosCampos()) {
    //     enviarFormulario(formRegister, alertaError, alertaExito,formRegister);
    // } else {
    //     alertaError.classList.add("alertaError");
    //     setTimeout(() => {
    //         alertaError.classList.remove("alertaError");
    //     }, 3000);
    // }
});

// Mostrar alerta
function mostrarAlerta(referencia, mensaje) {
    eliminarAlerta(referencia);
    const alertaDiv = document.createElement("div");
    alertaDiv.classList.add("alerta");
    alertaDiv.textContent = mensaje;
    referencia.appendChild(alertaDiv);
}

// Eliminar alerta
function eliminarAlerta(referencia) {
    const alerta = referencia.querySelector(".alerta");
    if (alerta) alerta.remove();
}

// Enviar formulario
function enviarFormulario(form, alertaError, alertaExito, body) {
    if (validarTodosLosCampos()) {

        const formData = new FormData(body);
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                console.log('Respuesta del servidor:', data);
                alert('¡Tu mensaje ha sido enviado exitosamente!');
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
                alert('Hubo un problema al enviar tu mensaje.');
            });


        form.reset();
        alertaExito.classList.add("alertaExito");
        setTimeout(() => {
            alertaExito.classList.remove("alertaExito");
        }, 3000);

        // Limpia las clases de error en los campos
        campos.forEach(({ campo }) => {
            campo.parentElement.classList.remove("error");
        });

        return;
    }

    alertaError.classList.add("alertaError");
    setTimeout(() => {
        alertaError.classList.remove("alertaError");
    }, 3000);
}

const btnInicio = document.getElementById("btn-inicio");

// // Redirige a la página de inicio cuando se hace clic en el botón
// btnInicio.addEventListener("click", () => {
//     window.location.href="index.html"; // Cambia '/' por la ruta de tu página de inicio si es distinta
// });
