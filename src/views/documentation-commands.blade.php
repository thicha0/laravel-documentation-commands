<!DOCTYPE html>
<html lang="en">
<head>
    <title>Documentation Commands</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar img {
            max-height: 40px;
            margin-right: 10px;
        }

        .sidebar {
            position: fixed;
            height: 100%;
            width: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            top: 56px; /* Height of the sticky navbar */
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .command {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        h2 {
            font-size: 20px;
            color: #333;
            background-color: #d8e1e8; /* Light blue header background */
            padding: 10px; /* Add space below header */
            margin-bottom: 0; /* Add space below header */
        }

        .command h3 {
            font-size: 16px;
            color: #555;
            font-weight: bold; /* Make subtitles bold */
        }

        .command p {
            margin-bottom: 10px;
        }

        .command table {
            border-collapse: collapse;
            width: 100%;
        }

        .command th, .command td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .command th {
            background-color: #f2f2f2;
        }

        h2 .chip {
            display: inline-block;
            padding: 0 10px;
            height: 20px;
            font-size: 10px;
            line-height: 20px;
            border-radius: 25px;
            background-color: #304674;
            color: white;
        }

        .folder-title {
            font-size: 16px; /* Smaller font size for folders */
            font-weight: bold;
            margin-bottom: 10px;
            cursor: pointer; /* Add cursor pointer for collapsible folders */
        }

        .folder-commands {
            display: none; /* Initially hide folder commands */
            margin-left: 10px; /* Indent folder commands */
        }

        .folder-commands.active {
            display: block; /* Display folder commands when active */
        }

        .divider {
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }

        .menu-list {
            list-style: none; /* Remove bullet points for the menu items */
            padding: 0;
        }

        .menu-link {
            color: #333;
            text-decoration: none;
        }

        .menu-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            Documentation Commands
        </a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky">
                    <ul class="menu-list">
                        @foreach ($customCommands as $folder => $commands)
                            <li>
                                <div class="folder-title">{{ $folder }}</div>
                                <ul class="folder-commands">
                                    @foreach ($commands as $command)
                                        <li>
                                            <a class="menu-link" href="#{{ $folder }}-{{ $loop->index + 1 }}">{{ $command['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 content">
                @foreach ($customCommands as $folder => $commands)
                    <div id="{{ $folder }}" class="folder-title">{{ $folder }}</div>
                    @foreach ($commands as $command)
                        <h2>
                            {{ $command['name'] }}
                            @if ($command['cron'] !== null)
                                <div class="chip">Cron</div>
                            @endif
                        </h2>
                        <div class="command" id="{{ $folder }}-{{ $loop->index + 1 }}">
                            <h3>Signature</h3>
                            <p>{{ $command['signature'] }}</p>
                            <h3>Description</h3>
                            <p>{{ $command['description'] }}</p>
                            @if ($command['cron'] !== null)
                            <h3>Cron</h3>
                            <p>{{ $command['cron']['method'] }}({{ $command['cron']['parameter'] }})</p>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Add JavaScript for collapsing and expanding folders
        document.addEventListener('DOMContentLoaded', function() {
            const folderTitles = document.querySelectorAll('.folder-title');
            folderTitles.forEach((folderTitle) => {
                folderTitle.addEventListener('click', () => {
                    const folderCommands = folderTitle.nextElementSibling;
                    folderCommands.classList.toggle('active');
                });
            });
        });
    </script>
</body>
</html>
