document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.count-up'); // Seleccionamos todos los contadores

    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-to'); // Valor final
        const increment = target / 200; // Incremento por paso (ajusta para mayor o menor velocidad)

        const updateCount = () => {
            const current = +counter.innerText; // Valor actual
            if (current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(updateCount, 10); // Llama de nuevo hasta llegar al target
            } else {
                counter.innerText = target; // Asegura que termine en el valor correcto
            }
        };

        updateCount(); // Inicia la animación
    };

    // Configuración del IntersectionObserver
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                animateCounter(counter); // Activa la animación
                observer.unobserve(counter); // Deja de observar para no reiniciar la animación
            }
        });
    }, { threshold: 0.5 }); // La animación comienza cuando el 50% del contador es visible

    // Aplicar el observer a cada contador
    counters.forEach(counter => {
        observer.observe(counter);
    });
});
