<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Foundation 4</title>

  <!-- If you are using CSS version, only link these 2 files, you may add app.css to use for your overrides if you like. -->
  <link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}" />
  <link rel="stylesheet" href="{{ URL::asset('css/foundation.css') }}" />

  <!-- If you are using the gem version, you need this only -->
  <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />

  <script src="{{ URL::asset('js/vendor/custom.modernizr.js') }}"></script>

</head>
<body>

{{ $content }}

  <!-- body content here -->

  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? '/js/vendor/zepto.js' : '/js/vendor/jquer.jsy') +
  '><\/script>')
  </script>
  <script src="{{ URL::asset('js/foundation/foundation.js') }}"></script>
  <script src="{{ URL::asset('js/foundation/foundation.alerts.js') }}"></script>
  <script src="{{ URL::asset('js/foundation/foundation.clearing.js') }}"></script>
  <script src="{{ URL::asset('js/foundation/foundation.cookie.js') }}"></script>
  <script src="{{ URL::asset('js/foundation/foundation.dropdown.js') }}"></script>
  <script src="{{ URL::asset('js/foundation/foundation.forms.js') }}"></script>
  <script>
    $(document).foundation();
  </script>
  @yield('scripts')
</body>
</html>