<?php


class Ssh
{

    private string $server;
    private string $username;
    private string $password;
    private string $port;

    /**
     * Ssh constructor.
     */
    public function __construct(string $server, string $username, string $password, string $port)
    {
        $this->server =$server;
        $this->username =$username;
        $this->password =$password;
        $this->port =$port;
    }

    /**
     * @param string $cmd
     * @return string
     * @throws Exception
     */
    public function command (string $cmd) :string

    {
        $connection = ssh2_connect($this->getServer(), $this->getPort());
        if (!$connection) {
            throw new Exception("fail: unable to establish connection\nPlease IP or if server is on and connected");
        }
        $pass_success = ssh2_auth_password($connection, $this->getUsername(), $this->getPassword());
        if (!$pass_success) {
            throw new Exception("fail: unable to establish connection\nPlease Check your password");
        }
        $stream = ssh2_exec($connection, $cmd);
        $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($errorStream, true);
        stream_set_blocking($stream, true);
        $output = stream_get_contents($stream);
        fclose($stream);
        fclose($errorStream);
        ssh2_exec($connection, 'exit');
        unset($connection);
        return $output;
    }

    /**
     * @return string
     */
    public function getServer(): string
    {
        return $this->server;
    }

    /**
     * @param string $server
     */
    public function setServer(string $server): void
    {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     */
    public function setPort(string $port): void
    {
        $this->port = $port;
    }



}