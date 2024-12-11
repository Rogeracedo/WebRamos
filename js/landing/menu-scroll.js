let lastScroll = 0;

document.addEventListener('scroll', () => {
    const navbar = document.querySelector('#navbar'); // Seleccionamos el navbar
    const currentScroll = window.scrollY;

    if (currentScroll > lastScroll && currentScroll > 100) {
        // Si hacemos scroll hacia abajo y pasamos 100px, ocultar navbar
        navbar.classList.add('hide');
    } else {
        // Si hacemos scroll hacia arriba, mostrar navbar
        navbar.classList.remove('hide');
    }

    lastScroll = currentScroll;
});
