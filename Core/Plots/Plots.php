<?php
include_once 'Conf/Storage.php';
include_once 'Core/Disk/Disk.php';
include_once 'Core/Ssh/Ssh.php';
class Plots
{

    private $disk;
    private $ssh;
    private array $storage;
    private string $red;
    /**
     * Plots constructor.
     */
    public function __construct(string $storage, int $red)
    {
        $this->setStorage(Storage::getStorage($storage));
        $this->setDisk( new Disk());
        $this->setRed($this->getStorage()["red".$red]);
    }

    public function sendPlot (string $pathPlots){
        $script = "";
        if ($plotsNum = shell_exec('ls '.trim(str_replace('ls','',$pathPlots)).'  | wc -l') > 0){
            $this->setSsh( new Ssh($this->getRed(), 'xxxx','xxxx', '12322'));

            $resultShell = $this->getSsh()->lineCommand('for ruta in $(df -h | grep /storage/chia/storage/); do echo -$ruta; done ');
            $discos = $this->getDisk()->getDisks($resultShell);
            $pathCopyPlot = $this->getDisk()->diskAvailable($discos);


            foreach ($this->plotsList($pathPlots) as $plot)
            {
                if ($this->plotSending() === 0)
                {
                    $this->addPlotQueue($plot);
                    $shell = 'sshpass -p "xxxx" rsync -av -e "ssh -p12322 -T -c aes128-gcm@openssh.com -o Compression=no -x"  '.trim(str_replace('ls','',$pathPlots)).'/'.trim($plot).' xxxxx@'.trim($this->getRed()).':'.$pathCopyPlot.' ';
                    echo $shell;
                    print shell_exec(trim($shell));
                    return $plot;
                }

                return 'espere por favor..';
            }

        }else{
            echo 'espere por favor...';
        }
    }

    /**
     * @param string $plotName
     * @param string $pathPlots
     */
    public function deletePlot(string $plotName, string $pathPlots)
    {
        print shell_exec('echo "xxxx" |  sudo -S -k  rm '.$pathPlots.'/'.$plotName);
        $fp = fopen("Data/plotsQueue.txt", "w");
        fclose($fp);
    }


    /**
     * @param string $pathPlots
     * @return array
     */
    public function plotsList(string $pathPlots) : array
    {
        $resultShell = shell_exec('for plotName in $('.$pathPlots.'); do echo ?$plotName; done');
        $resultPlots = explode('?',trim($resultShell));
        unset($resultPlots[0]);
        return $resultPlots;
    }


    /**
     * @param string $plotName
     */
    private function addPlotQueue(string $plotName)
    {
        $fp = fopen("Data/plotsQueue.txt", "a+");
        fwrite($fp, $plotName."\n");
        fclose($fp);
    }

    /**
     * @return int
     */
    public function plotSending (): int{
        return str_word_count(file_get_contents("Data/plotsQueue.txt"),0);
    }

    /**
     * @param string $plotName
     */
    private function isExistPlotQueue(string $plotName) : int
    {
        $fp = fopen("Data/plotsQueue.txt", "r");
        while (!feof($fp)) {
            $plotsQueue =  fgets($fp);
            if ($plotsQueue === $plotName)
            {
               return 1;
            }
        }
        fclose($fp);
        return 0;
    }



    /**
     * @return array
     */
    public function getStorage(): array
    {
        return $this->storage;
    }

    /**
     * @param array $storage
     */
    public function setStorage(array $storage): void
    {
        $this->storage = $storage;
    }

    /**
     * @return mixed
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @param mixed $disk
     */
    public function setDisk($disk): void
    {
        $this->disk = $disk;
    }

    /**
     * @return mixed
     */
    public function getSsh()
    {
        return $this->ssh;
    }

    /**
     * @param mixed $ssh
     */
    public function setSsh($ssh): void
    {
        $this->ssh = $ssh;
    }

    /**
     * @return string
     */
    public function getRed(): string
    {
        return $this->red;
    }

    /**
     * @param string $red
     */
    public function setRed(string $red): void
    {
        $this->red = $red;
    }











}
