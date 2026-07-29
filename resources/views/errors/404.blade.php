<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Page Not Found</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #0f172a;
            --muted: #475569;
            --surface: rgba(255, 255, 255, 0.68);
            --line: rgba(148, 163, 184, 0.38);
            --accent-a: #0ea5e9;
            --accent-b: #22c55e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: "Space Grotesk", "Segoe UI", sans-serif;
            background:
                radial-gradient(900px 480px at 8% 10%, rgba(14, 165, 233, 0.22), transparent 65%),
                radial-gradient(800px 500px at 92% 90%, rgba(34, 197, 94, 0.20), transparent 68%),
                linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--ink);
            padding: 1.5rem;
            overflow: hidden;
        }

        .card {
            width: 100%;
            max-width: 560px;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 22px;
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.16);
            backdrop-filter: blur(10px);
            padding: 2.4rem 2rem;
            text-align: center;
            animation: rise 420ms ease-out;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid rgba(14, 165, 233, 0.4);
            background: rgba(14, 165, 233, 0.12);
            color: #075985;
            font-size: 0.78rem;
            padding: 0.35rem 0.7rem;
            margin-bottom: 1rem;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        h1 {
            margin: 0;
            font-size: clamp(2.8rem, 10vw, 5rem);
            line-height: 0.95;
            letter-spacing: -0.04em;
        }

        p {
            margin: 1rem auto 0;
            color: var(--muted);
            max-width: 36ch;
            font-size: 1.03rem;
            line-height: 1.5;
        }

        a {
            display: inline-block;
            margin-top: 1.4rem;
            text-decoration: none;
            background: linear-gradient(120deg, var(--accent-a), var(--accent-b));
            color: #ffffff;
            padding: 0.78rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.28);
            transition: transform 140ms ease, box-shadow 140ms ease, filter 140ms ease;
        }

        a:hover {
            transform: translateY(-2px);
            filter: saturate(1.08);
            box-shadow: 0 12px 28px rgba(14, 165, 233, 0.36);
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 2rem 1.25rem;
                border-radius: 18px;
            }

            p {
                font-size: 0.98rem;
            }
        }
    </style>
</head>
<body>
    <main class="card">
        <span class="badge">Oops! Wrong Turn</span>
        <h1>404</h1>
        <p>The page you are looking for was not found.</p>
        <a href="{{ route('home') }}">Go Back Home</a>
    </main>
</body>
</html>