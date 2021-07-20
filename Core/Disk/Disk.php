<?php


class Disk
{

    private string $fileSystem;
    private string $sizeDisk;
    private string $usedDisk;
    private string $availableSizeDisk;
    private string $usedDisk_percentage;
    private string $mountedDisk;

    /**
     * Disk constructor
     */
    public function __construct()
    {

    }

    /**
     * @param array $disks
     * @return string
     */
    public function diskAvailable(array $disks): string
    {
        $diskAvailable = array();
        foreach ($disks as $disk)
        {
            if ($this->checkSpaceDisk($disk['use_percentage'])){
                $diskAvailable[] .= $disk['mounter'];
            }
        }
        return trim($diskAvailable[rand(0,sizeof($diskAvailable)-1)]);
    }

    /**
     * @param string $usedDisk_percentage
     * @return bool
     */
    public function checkSpaceDisk (string $usedDisk_percentage) : bool
    {
        $percentage = (int) str_replace ('%','',$usedDisk_percentage);
        if ($percentage === 100 or $percentage === 99)
        {
            return false;
        }else{
            return true;
        }
    }

    /**
     * @param string $resultShell
     * @return array
     */
    public function getDisks(string $resultShell): array
    {
        $result = explode('-',trim($resultShell));
        $disks = array();
        $flag = 0;

        for ($i = 1; $i < sizeof($result); $i++)
        {
            switch ($flag){
                case 0:
                    $this->setFileSystem( $result[$i] );
                    $flag = 1;
                    break;
                case 1:
                    $this->setSizeDisk( $result[$i] );
                    $flag = 2;
                    break;
                case 2:
                    $this->setUsedDisk( $result[$i] );
                    $flag = 3;
                    break;
                case 3:
                    $this->setAvailableSizeDisk( $result[$i] );
                    $flag = 4;
                    break;
                case 4:
                    $this->setUsedDiskPercentage( $result[$i] );
                    $flag = 5;
                    break;
                case 5:
                    $this->setMountedDisk( $result[$i] );
                    $flag = 6;
                case 6:
                    $disks[] = [
                        'fileSystem' => $this->getFileSystem(),
                        'size'=> $this->getSizeDisk(),
                        'used'=> $this->getUsedDisk(),
                        'available'=> $this->getAvailableSizeDisk(),
                        'use_percentage'=> $this->getUsedDiskPercentage(),
                        'mounter'=> $this->getMountedDisk()
                    ];
                    $flag = 0;
                    break;
            }
        }

        return $disks;

    }



    /**
     * @return string
     */
    public function getStorage(): string
    {
        return $this->storage;
    }

    /**
     * @param string $storage
     */
    public function setStorage(string $storage): void
    {
        $this->storage = $storage;
    }

    /**
     * @return string
     */
    public function getFileSystem(): string
    {
        return $this->fileSystem;
    }

    /**
     * @param string $fileSystem
     */
    public function setFileSystem(string $fileSystem): void
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @return string
     */
    public function getSizeDisk(): string
    {
        return $this->sizeDisk;
    }

    /**
     * @param string $sizeDisk
     */
    public function setSizeDisk(string $sizeDisk): void
    {
        $this->sizeDisk = $sizeDisk;
    }

    /**
     * @return string
     */
    public function getUsedDisk(): string
    {
        return $this->usedDisk;
    }

    /**
     * @param string $usedDisk
     */
    public function setUsedDisk(string $usedDisk): void
    {
        $this->usedDisk = $usedDisk;
    }

    /**
     * @return string
     */
    public function getAvailableSizeDisk(): string
    {
        return $this->availableSizeDisk;
    }

    /**
     * @param string $availableSizeDisk
     */
    public function setAvailableSizeDisk(string $availableSizeDisk): void
    {
        $this->availableSizeDisk = $availableSizeDisk;
    }

    /**
     * @return string
     */
    public function getUsedDiskPercentage(): string
    {
        return $this->usedDisk_percentage;
    }

    /**
     * @param string $usedDisk_percentage
     */
    public function setUsedDiskPercentage(string $usedDisk_percentage): void
    {
        $this->usedDisk_percentage = $usedDisk_percentage;
    }

    /**
     * @return string
     */
    public function getMountedDisk(): string
    {
        return $this->mountedDisk;
    }

    /**
     * @param string $mountedDisk
     */
    public function setMountedDisk(string $mountedDisk): void
    {
        $this->mountedDisk = $mountedDisk;
    }




}