@extends('defaults.layout')

@section('title', 'Page Title')

@section('pg_content')
    <h1>Welcome to CodeIgniter &amp; Laravel Blade Template Engine!</h1>

    <div id="body">
        <p>The page you are looking at is being generated dynamically by CodeIgniter / Blade.</p>

        <p>If you would like to edit this page you'll find it located at:</p>
        <code>application/views/home/index.blade.php</code>

        <p>The corresponding controller for this page is found at:</p>
        <code>application/controllers/Welcome.php</code>

        <p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
@endsection

@section('script')
@endsection
