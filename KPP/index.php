<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的主页</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
        }

        .header {
            background-color: #2196F3;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .nav {
            background-color: #1976D2;
            padding: 1rem;
        }

        .nav a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
            padding: 0.5rem;
        }

        .nav a:hover {
            background-color: #64B5F6;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .footer {
            background-color: #1976D2;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .card {
            background: white;
            padding: 2rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>欢迎来到我的网站</h1>
    </header>

    <nav class="nav">
        <a href="/">首页</a>
        <a href="/about">关于我们</a>
        <a href="/products">产品介绍</a>
        <a href="/contact">联系我们</a>
    </nav>

    <div class="container">
        <div class="card">
            <h2>最新消息</h2>
            <p><?php echo date('Y-m-d'); ?> - 网站正式上线！</p>
            <p>这是一个使用PHP构建的基础网站模板。</p>
        </div>

        <div class="card">
            <h3>功能特点</h3>
        <ul>
            <li>响应式设计</li>
            <li>简洁的界面</li>
            <li>易于扩展</li>
        </ul>
        </div>
    </div>

    <footer class="footer">
        <p>© <?php echo date('Y'); ?> 版权所有。保留所有权利。</p>
    </footer>
</body>
</html>