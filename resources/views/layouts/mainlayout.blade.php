<html lang="en">
<head>
    <title>Trishaba - @yield('title')</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <!-- Header -->
    <header>
        <h1>First Project</h1>
        <nav>
            <a href="/view">Views</a>       <!-- give name of route which page you want to open -->
            <a href="/about">About Us</a>
            <a href="/Post">Post</a>
        </nav>
    </header> 

    <!-- Main Layout -->
    <div class="container">

        <!-- Sidebar -->
        <aside>
            <h3>Related Links</h3>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/Post">Post</a></li>
                <li><a href="/view">Views</a></li>
            </ul>
        </aside>

        <!-- Content -->
        <main>

            @hasSection('content')  <!-- cheack content name no section baniyo che ke nai , also cheack data set  or not -->
                @yield('content') <!-- take dynamic value from other page -->
            @else
                <h2>No Data Found.</h2>
            @endif
           
        </main>

    </div>

    <!-- Footer -->
    <footer>
        2025 My First Website
    </footer>

</body>
</html>
