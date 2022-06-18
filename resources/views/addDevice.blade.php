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
    <link href="././css/cover.css" rel="stylesheet">
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

    <form class="form-signin w-50 ml-0 mr-0 mx-auto mt-5" name="addDevice">
      <div class="row">
        <div class="col-12">
          <h3 class="cover-heading">Add a new device</h3>
          <div class="row">
            <div class="col-6 mb-3">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" placeholder="" required="">
              <div class="invalid-feedback">
                Device name is required.
              </div>
            </div>
            <div class="col-6 mb-3">
              <label for="state">Type</label>
              <select class="custom-select d-block w-100" id="type" required="">
                <option value="">Choose...</option>
                <option name="type" value="Appliance">Appliance</option>
                <option name="type" value="Electronics">Electronics</option>
                <option name="type" value="Lights">Lights</option>
                <option name="type" value="Other">Other</option>
              </select>
              <div class="invalid-feedback">
                Please provide a valid type.
              </div>
            </div>
          </div>
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" placeholder="">
          <button class="btn btn-success btn-lg btn-block mt-5" type="submit">Add</button>
        </div>
      </div>
    </form>

      <footer class="mastfoot mt-auto ml-0 mr-0 mx-auto">
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
            console.log('start!');
        };

        document.forms.addDevice.onsubmit = function () {
            let data = {
                'name': this.name.value,
                'type': this.type.value,
                'description': this.description.value,
                'isActive': false
            }
            let outgoingMessage = JSON.stringify(data);
            console.log(outgoingMessage);
            socket.send(outgoingMessage);
        };

        socket.onmessage = function(event) {};

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
