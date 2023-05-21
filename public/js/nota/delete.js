window.onload = function () {
    console.log('window loaded');
    addDeleteListener();


}

function addDeleteListener() {
    let enlaces = document.querySelectorAll("#tbody_notas a[data-bs-notaId]");
    enlaces.forEach(enlaceDelete => {
        enlaceDelete.onclick = deleteNota;
    });
}

function deleteNota(event) {
    event.preventDefault();

    console.log('mostrando diálogo...');
    showModal2('modal', "Confirmación", "¿Está seguro/a de que desea eliminar la nota?", "Aceptar", "Cancelar", () => {
        doDelete(event.target);
    }, null);

}
function doDelete(htmlObjetc_link) {
    console.log('do delete');
    let delete_url = htmlObjetc_link.getAttribute('href');

    console.log(htmlObjetc_link.getAttribute('href'));

    fetch(BASE_URL + delete_url)

        .then((response) => {
            if (response.status === 200) {
                return response.text();

            } else {
                console.log("Something went wrong on API server!");
                return false;
            }
        })
        .then((response) => {
            if (response !== false) {
                //https://developer.mozilla.org/en-US/docs/Web/API/Document/open
                //https://developer.mozilla.org/en-US/docs/Web/API/Document/write 
                //Inicialmente parece que funciona esta solución, pero se desaconseja porque no se cargarán los scripts introducidos con write (el diálogo se mostrará la primera vez que se elimina, pero no la segunda)
                // document.open();
                // document.write(response);
                // document.close();

                //Reemplazo todo el DOM con la respuesta del servidor
                document.getElementsByTagName("html")[0].innerHTML = response;
                //Como no se dispara el evento window loaded, hay que volver a añadir los listeners de delete manualmente
                addDeleteListener();
            }
            else {
                //Se podría añadir un div para mostrar el mensaje al usuario, pero para simplificar, muestro mensaje de error en consola
                console.error("No se ha podido eliminar la nota. ");
            }

        })
        .catch((error) => {
            console.error('Ha ocurrido un error en doDelete' + error);
        });



}

