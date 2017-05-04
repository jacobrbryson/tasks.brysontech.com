<h1>
    Setup
</h1>
<h2>
    Steps for local environment.
</h2>
<ul>
    <li>
        Update parameters.yml
        <ul>
            <li> 
                database_name: <i>tasks</i>
            </li>
            <li>
                database_user: <i>taskslocal</i>
            </li>
            <li>
                database_password: <i>ChickenAndRibs</i>
            </li>
        </ul>
    </li>
    <li>
        Log in to MySQL as root and run the following three queries
        <ul>
            <li>
                CREATE DATABASE tasks;
            </li>
            <li>
                CREATE USER 'taskslocal'@'localhost' IDENTIFIED BY 'ChickenAndRibs';
            </li>
            <li>
                GRANT ALL PRIVILEGES ON tasks.* TO 'taskslocal'@'localhost';
            </li>
        </ul>
    </li>
    <li>
        <a href="/build">Last click here</a>
    </li>
</ul>