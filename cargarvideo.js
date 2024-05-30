document.getElementById('crearPreguntaForm').addEventListener('submit', function(event) {
    event.preventDefault();
  
    const titulo = document.getElementById('exampleFormControlInput1').value;
    const descripcion = document.getElementById('exampleFormControlTextarea1').value;
    const videoFile = document.getElementById('videoUpload').files[0];
  
    if (videoFile) {
      document.getElementById('message').innerText = 'Subiendo video...';
      uploadToDropbox(videoFile, (error, videoUrl) => {
        if (error) {
          document.getElementById('message').innerText = 'Error al subir el video: ' + error.message;
        } else {
          document.getElementById('message').innerText = 'Video subido, guardando artículo...';
          saveArticleWithVideo(titulo, descripcion, videoUrl);
        }
      });
    } else {
      document.getElementById('message').innerText = 'Por favor, selecciona un archivo de video.';
    }
  });
  
  function uploadToDropbox(file, callback) {
    const ACCESS_TOKEN = 'sl.B2OfZ6_6fzrLo6zGsKw-TJs8rZ6gNZduvtpoZeQAck59d39ppTDQtVJeZkjlHroT0BFI7dmTFtPQblqAY44vRvG6hZBjdoEbQLrVTEv5M4ISUscdY-g598XH5hD3XjX2Eou-xpt0BO8i';
    const url = 'https://content.dropboxapi.com/2/files/upload';
    const args = {
      path: '/' + file.name,
      mode: 'add',
      autorename: true,
      mute: false,
      strict_conflict: false
    };
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Authorization', 'Bearer ' + ACCESS_TOKEN);
    xhr.setRequestHeader('Content-Type', 'application/octet-stream');
    xhr.setRequestHeader('Dropbox-API-Arg', JSON.stringify(args));
  
    xhr.onload = function() {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        getSharedLink(response.path_lower, callback);
      } else {
        callback(new Error('Error en la subida: ' + xhr.responseText));
      }
    };
  
    xhr.onerror = function() {
      callback(new Error('Error al subir el video.'));
    };
  
    xhr.send(file);
  }
  
  function getSharedLink(filePath, callback) {
    const ACCESS_TOKEN = 'sl.B2OfZ6_6fzrLo6zGsKw-TJs8rZ6gNZduvtpoZeQAck59d39ppTDQtVJeZkjlHroT0BFI7dmTFtPQblqAY44vRvG6hZBjdoEbQLrVTEv5M4ISUscdY-g598XH5hD3XjX2Eou-xpt0BO8i';
    const url = 'https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings';
    const args = {
      path: filePath
    };
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Authorization', 'Bearer ' + ACCESS_TOKEN);
    xhr.setRequestHeader('Content-Type', 'application/json');
  
    xhr.onload = function() {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        const sharedLink = response.url.replace('?dl=0', '?raw=1'); // Ajusta el enlace para obtener una URL directa
        callback(null, sharedLink);
      } else {
        callback(new Error('Error al obtener enlace compartido: ' + xhr.responseText));
      }
    };
  
    xhr.onerror = function() {
      callback(new Error('Error al obtener el enlace compartido.'));
    };
  
    xhr.send(JSON.stringify(args));
  }
  
  function saveArticleWithVideo(titulo, descripcion, videoUrl) {
    fetch('/save_article', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ titulo, descripcion, videoUrl })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.getElementById('message').innerText = 'Artículo y video añadidos con éxito.';
        // Aquí puedes añadir el nuevo artículo a la lista visible en la página sin recargarla
      } else {
        document.getElementById('message').innerText = 'Error al guardar el artículo en la base de datos: ' + data.message;
      }
    })
    .catch(error => {
      document.getElementById('message').innerText = 'Error al guardar el artículo en la base de datos: ' + error.message;
    });
  }
  