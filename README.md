<ol>
    <li>Create database mongodb dan mysql</li>
    <li>Restore mongodb sera json dan sera sql ke database masing-masing. Untuk file restore nya berada di <b>Database</b> > <b>Schema</b></li>
    <li>Atur .env untuk database nya 
        <br><code>DB_CONNECTION=mysql</code>
        <br><code>DB_HOST=localhost</code>
        <br><code>DB_PORT=3306</code>
        <br><code>DB_DATABASE=sera</code>
        <br><code>DB_USERNAME=root</code>
        <br><code>DB_PASSWORD=</code>
        <br>
        <br><code>MONGODB_CONNECTION=mongodb</code>
        <br><code>MONGODB_HOST=localhost</code>
        <br><code>MONGODB_PORT=27017</code>
        <br><code>MONGODB_DATABASE=sera</code>
        <br><code>MONGODB_USERNAME=</code>
        <br><code>MONGODB_PASSWORD=</code></li>
    <li>Jalan kan <code>composer install</code></li>
    <li>Start server <code>php -S localhost:8000 public/index.php</code></li>
    <li>Buka <code>localhost:8000/api/documentation</code> untuk menjalankan swagger</li>
</ol>

Untuk lengkapnya silahkan buka file <b>Sera.docx</b>
