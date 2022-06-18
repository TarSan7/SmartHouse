<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Cover Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/cover/">

    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/cover.css" rel="stylesheet">
  </head>

  <body class="text-center">

    <div class="container d-flex h-100 p-3 mx-auto flex-column">
      <header class="masthead">
        <div class="inner">
          <h3 class="masthead-brand">WebSocket Home</h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" href="{{ route('home') }}">Home</a>
            <a class="nav-link" href="{{ route('devices') }}">Devices</a>
            <a class="nav-link" href="{{ route('addDevice') }}">Add device</a>
          </nav>
        </div>
      </header>

      <div class="row w-50 ml-0 mr-0 mx-auto mt-5">
        <div class="col-12">
          <h3 class="cover-heading">All connected devices</h3>

          <div id="devices">

          </div>
        </div>
      </div>

      <footer class="mastfoot ml-0 mr-0 mx-auto">
        <div class="inner">
            <p class="mt-5 mb-3 text-muted text-center">© S & M 2022</p>
        </div>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
    <script>
        let socket = new WebSocket("ws://77.47.232.180:8080");

        socket.onopen = function(e) {
            socket.send('start');
            console.log('start!');
        };

        socket.onmessage = function(event) {
            let jsonInfo = JSON.parse(event.data);
            let devices  = document.getElementById('devices');

            devices.innerHTML = '';
            for (let key in jsonInfo) {
                devices.insertAdjacentHTML('beforeend', addDevice(jsonInfo[key]));
            }
        };

        /**
         * Forming html for new device
         * @param deviceInfo
         * @returns {string}
         */
        function addDevice(deviceInfo) {
            let backgroundStyle = '';
            let backgroundClass = '';
            let actionButton    = '';

            if (deviceInfo.is_active) {
                backgroundStyle = 'style="background-color:#74c69d" ';
                backgroundClass = 'class="mt-3 card box-shadow"';
                actionButton    = 'Turn off';
            } else {
                backgroundClass = 'class="mt-3 card box-shadow bg-secondary"';
                actionButton    = 'Turn on';
            }

            return `<div ` + backgroundStyle + backgroundClass + `>
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Device name: ` + deviceInfo.name + `</h4>
                        </div>
                        <div class="card-body">
                          <p>Type: ` + deviceInfo.type + `</p>
                          <p>Description: ` + deviceInfo.description + `</p>
                          <button type="button" onclick="toActive(` + deviceInfo.id + `)" class="btn btn-lg btn-block btn-success" >` + actionButton + `</button>
                          <button type="button" onclick="deleteDevice(` + deviceInfo.id + `)" class="btn btn-lg btn-block  btn-outline-dark">Remove device</button>
                        </div>
                      </div>`;
        }

        function toActive(id) {
            socket.send(JSON.stringify({'id': id, 'action': 'change'}));
        }

        function deleteDevice(id) {
            socket.send(JSON.stringify({'id': id, 'action': 'delete'}));
        }

        socket.onclose = function(event) {
            if (event.wasClean) {
                console.log(`[close] Connection stopped, code=${event.code} reason=${event.reason}`);
            } else {
                console.log('[close] connection interrupted');
            }
        };

        socket.onerror = function(error) {
            console.log(`[error] ${error.message}`);
        };
    </script>
  </body>
</html>
