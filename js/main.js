setInterval(() => {
    let fecha__completa = document.getElementById("fecha__completa");
    let hora__estado = document.getElementById("hora__estado");
    let hora__tiempo = document.getElementById("hora__tiempo");
    let fecha = new Date();
    let semana = ["Domingo", "Lunes", "Martes", "Miercoles", "Juves", "Viernes", "Sabado"]
    let mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
    let diaNuevo;
    let estado;
    if (fecha.getHours() >= 12) {
        estado = "PM"
    } else {
        estado = "AM"
    }
    if (fecha.getDate() < 10) {
        diaNuevo = `0${fecha.getDate()}`
    } else {
        diaNuevo = `${fecha.getDate()}`
    }


    fecha__completa.textContent = `${semana[fecha.getDay()] + " " + diaNuevo + " de " + mes[fecha.getMonth()] + " del " + fecha.getFullYear()}  `
    hora__estado.textContent = `${estado}`;
    hora__tiempo.textContent = `${fecha.toLocaleTimeString()}`

}, 1000);