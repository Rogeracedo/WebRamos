document.getElementById('ver-mas-servicios').addEventListener('click', function () {
    const servicios = document.querySelectorAll('.service-item:nth-child(n+4)'); // Selecciona las tarjetas ocultas
    servicios.forEach((servicio) => {
        if (servicio.style.display === 'block') {
            servicio.style.display = 'none'; // Oculta si ya está visible
            this.textContent = 'Ver más servicios';
        } else {
            servicio.style.display = 'block'; // Muestra las tarjetas
            servicio.style.animation = 'deslizar 0.5s ease-in-out'; // Efecto hacia abajo
            this.textContent = 'Ver menos servicios';
        }
    });
});
