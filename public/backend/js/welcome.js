document.addEventListener('DOMContentLoaded', function () { 
    const searchQuery = document.getElementById('searchQuery');
    const searchResults = document.querySelector('.search-results');
    let debounceTimeout;

    // Función para realizar la búsqueda
    function buscarEventos() {
        const query = searchQuery.value.trim();

        // Si el campo de texto está vacío, limpiar resultados
        if (query === '') {
            searchResults.innerHTML = ''; // Limpiar resultados
            console.log("Campo de búsqueda vacío.");
            return; // Salir de la función
        }

        console.log("Realizando búsqueda con query:", query);

        // Realizar la petición AJAX para obtener los eventos filtrados
        fetch(`/buscar-eventos?query=${query}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            // Verificar respuesta del servidor
            if (data.message) {
                searchResults.innerHTML = `<p>${data.message}</p>`;
            } else {
                const titulo = data.titulo || 'Resultados'; // Usar título o valor por defecto
                searchResults.innerHTML = `<h2>${titulo}</h2>` + data.html;
            }
            console.log("Datos recibidos:", data);
        })
        .catch(error => {
            console.error('Error al cargar los eventos:', error);
            searchResults.innerHTML = `<p>Ocurrió un error al buscar eventos. Intenta nuevamente.</p>`;
        });
    }

    // Función para aplicar el debounce (evita llamadas excesivas)
    function debounce(func, delay) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(func, delay);
    }

    // Agregar evento de entrada al input
    searchQuery.addEventListener('input', function () {
        debounce(buscarEventos, 300); // Llamar a la función de búsqueda con un retardo de 300 ms
    });
});


/* document.addEventListener('DOMContentLoaded', function () {
  const searchQuery = document.getElementById('searchQuery');
  const categorySelect = document.querySelector('select[name="categoria"]');
  const searchResults = document.querySelector('.search-results');
  let debounceTimeout;

  // Función para realizar la búsqueda
  function buscarEventos() {
      const query = searchQuery.value.trim();
      const categoria = categorySelect.value;

      // Si la categoría es 0, no mostrar nada
      if (categoria === '0') {
          searchResults.innerHTML = ''; // Limpiar resultados
          return; // Salir de la función
      }

      // Realizar la petición AJAX para obtener los eventos filtrados
      fetch(`/buscar-eventos?query=${query}&categoria=${categoria}`, {
          headers: {
              'X-Requested-With': 'XMLHttpRequest'
          }
      })
      .then(response => {
          if (!response.ok) {
              throw new Error('Error en la respuesta del servidor');
          }
          return response.json();
      })
      .then(data => {
          // Si el servidor devuelve un mensaje de no encontrado
          if (data.message) {
              searchResults.innerHTML = `<p>${data.message}</p>`;
          } else {
              const titulo = data.titulo; // Obtener el título de la respuesta
              searchResults.innerHTML =`<h2>${titulo}</h2>` + data.html;
          }
      })
      .catch(error => {
          console.error('Error al cargar los eventos:', error);
          searchResults.innerHTML = `<p>Ocurrió un error al buscar eventos. Intenta nuevamente.</p>`;
      });
  }

  // Función para aplicar el debounce (evita llamadas excesivas)
  function debounce(func, delay) {
      clearTimeout(debounceTimeout);
      debounceTimeout = setTimeout(func, delay);
  }

  // Agregar evento de entrada al input
  searchQuery.addEventListener('input', function () {
      debounce(buscarEventos, 300); // Llamar a la función de búsqueda con un retardo de 300 ms
  });

  // Evento change en el select
  categorySelect.addEventListener('change', function () {
      buscarEventos(); // Llamar a la función de búsqueda inmediatamente al cambiar la categoría
  });
});
 */
  


// solo categorias 
   /*  document.addEventListener('DOMContentLoaded', function () {
      const categorySelect = document.querySelector('select[name="categoria"]');
      const searchResults = document.querySelector('.search-results');
  
      categorySelect.addEventListener('change', function () {
          const categoria = categorySelect.value;
  
          // Realizar la petición AJAX para obtener los eventos filtrados
          fetch(`/buscar-eventos?categoria=${categoria}`, {
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              }
          })
          .then(response => response.text())
          .then(html => {
              // Actualizar la sección de resultados con la respuesta HTML
              searchResults.innerHTML = html;
          })
          .catch(error => {
              console.error('Error al cargar los eventos:', error);
          });
      });
  }); */
  

// ESTA ES LA  2da MEJOR OPCION

/* document.addEventListener('DOMContentLoaded', function () {
  const searchQuery = document.getElementById('searchQuery');
  const categorySelect = document.querySelector('select[name="categoria"]');
  const searchResults = document.querySelector('.search-results');

  // Función para realizar la búsqueda
  function buscarEventos() {
      const query = searchQuery.value.trim();
      const categoria = categorySelect.value;

      // Si la categoría es 0, no mostrar nada
      if (categoria === '0') {
          searchResults.innerHTML = ''; // Limpiar resultados
          return; // Salir de la función
      }

      // Realizar la petición AJAX para obtener los eventos filtrados
      fetch(`/buscar-eventos?query=${query}&categoria=${categoria}`, {
          headers: {
              'X-Requested-With': 'XMLHttpRequest'
          }
      })
      .then(response => response.text())
      .then(html => {
          // Actualizar la sección de resultados con la respuesta HTML
          if (html !== ' "message": "Server Error"') {
              searchResults.innerHTML = html;
          } else {
              searchResults.innerHTML = ''; // Limpiar resultados en caso de error
          }
      })
      .catch(error => {
          console.error('Error al cargar los eventos:', error);
      });
  }

   // Función para aplicar el debounce (evita llamadas excesivas)
   function debounce(func, delay) {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(func, delay);
}


  // Agregar evento de entrada al input
  searchQuery.addEventListener('input', function () {
      buscarEventos(); // Llamar a la función de búsqueda
  });

  // Evento change en el select
  categorySelect.addEventListener('change', function () {
      buscarEventos(); // Llamar a la función de búsqueda
  });
}); */

