<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <a class="navbar-brand" href="/">{{ config('app.name','LMS')}}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Home <span class="sr-only"></span></a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="/about">About <span class="sr-only"></span></a>
      </li>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="/services">Services <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/posts">Blog <span class="sr-only"></span></a>
      </li>
           
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <a class="nav-link" href="/posts/create">Create Post<span class="sr-only"></span></a>
      </li>
    </ul>
  </div>
</nav>