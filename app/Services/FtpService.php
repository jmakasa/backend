<?php

namespace App\Services;

class FtpService
{
    protected $connection;
    protected $sftp;
    protected $hostname;
    protected $user;
    protected $pass;
    protected $rootpath;
    protected $ftpHost;
    protected $ftpHostlist;
    protected $ftpLogin;
    

    public function __construct($requestServer)
    {
        $this->ftpHostlist = [
            'akasa2206_uk' => [
                //213.175.200.150 ftp.akasa.co.uk
                'host' => env("FTP_UK_HOST", '213.175.200.150'),
                'user' => env("FTP_UK_USER", 'akasaweb@akasa.co.uk'),
                //'pass' => 'gzg81182$$UK23',
                'pass' => env("FTP_UK_PASS", 'gzg81182!?UK23'),
                'rootpath' => env("FTP_UK_ROOTPATH", ''),
            ],
            'akasa2206_tw' => [
             //   'host' => 'akasa.site.aplus.net','64.29.151.221'
             'host' => env("FTP_TW_HOST", '64.29.151.221'),
             
                'user' => 'akasa.site.aplus.net',
                'pass' => 'gzg81182',
                'rootpath' => '/akasa.com.tw/public'
            ],
            'akasa10_cn' => [
                'host' => 'akasa.site.aplus.net',
                'user' => 'akasa.site.aplus.net',
                'pass' => 'gzg81182',
                'rootpath' => '/akasa.com.tw/public'
            ],
        ];
        $this->ftpHost = $this->ftpHostlist[$requestServer];
        Logger()->debug("FtpService : ftpHost - " . var_export($this->ftpHost, true));
        Logger()->debug("FtpService : host - " . $this->ftpHost['host']);
        Logger()->debug("FtpService : gethostbyname - " . gethostbyname($this->ftpHost['host']));
        $this->connection  = ftp_connect($this->ftpHost['host'],21) or die("Unable to connect to server.");
        $this->ftpLogin = ftp_login($this->connection, $this->ftpHost['user'], $this->ftpHost['pass']);
        ftp_pasv($this->connection, true);
    }

     public function ftpHost()
    {
        return $this->ftpHostlist;
    }

    public function ftpLogin()
    {
        return $this->ftpLogin;
    }

    public function ftpConn()
    {
        $ftp = ftp_connect($this->ftpHost['host']);
        ftp_login($ftp, $this->ftpHost['user'], $this->ftpHost['pass']);
        ftp_pasv($ftp, true);
        return $ftp;
    }

    public function uploadFile($localFile, $remoteFile)
    {
        if (file_exists($localFile)){
            if (ftp_put($this->connection, $this->ftpHost['rootpath'].$remoteFile, $localFile, FTP_BINARY)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        
    }

    public function renameFile( $oldFile, $newFile)
    {

        if (ftp_rename($this->connection, $oldFile, $newFile)) {
            return true;
        } else {
            return false;
        }
    }

    public function delFile($file)
    {
        if (ftp_delete($this->connection, $file)) {
            return true;
        } else {
            return false;
        }
    }

    public function mkdir($dir)
    {
        // try to create the directory $dir
        if (ftp_mkdir($this->connection, $dir)) {
            return true;
        } else {
            return false;
        }
    }

    public function renameDir($dir)
    {
        // try to delete the directory $dir
        if (ftp_rmdir($this->connection, $dir)) {
            return true;
        } else {
            return false;
        }
    }
    public function closeConnection()
    {
        ftp_close($this->connection);
    }

    public function uploadLog()
    {
    }
    public function isDirExisted($path)
    {
        if (ftp_nlist($this->connection, $path) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function checkAndCreateFolder($remote_file){
        $aryRemotePath = explode("/", $this->ftpHost['rootpath'].$remote_file);
        for ($i = 1; $i < count($aryRemotePath) - 1; $i++) {
          $tempPath[] = $aryRemotePath[$i];
          $tPath = "/" . implode("/", $tempPath);
          if (!$this->isDirExisted($tPath)) {
            $this->mkdir($tPath);
          }
        }
    }
}
