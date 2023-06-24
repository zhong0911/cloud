<?php

declare(strict_types=1);

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Docker\API\Model;

class ContainersIdJsonGetResponse200
{
    /**
     * The ID of the container.
     *
     * @var string
     */
    protected $id;
    /**
     * The time the container was created.
     *
     * @var string
     */
    protected $created;
    /**
     * The path to the command being run.
     *
     * @var string
     */
    protected $path;
    /**
     * The arguments to the command being run.
     *
     * @var string[]
     */
    protected $args;
    /**
     * The state of the container.
     *
     * @var ContainersIdJsonGetResponse200State
     */
    protected $state;
    /**
     * The container's image.
     *
     * @var string
     */
    protected $image;
    /**
     * @var string
     */
    protected $resolvConfPath;
    /**
     * @var string
     */
    protected $hostnamePath;
    /**
     * @var string
     */
    protected $hostsPath;
    /**
     * @var string
     */
    protected $logPath;
    /**
     * TODO.
     *
     * @var mixed
     */
    protected $node;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $restartCount;
    /**
     * @var string
     */
    protected $driver;
    /**
     * @var string
     */
    protected $mountLabel;
    /**
     * @var string
     */
    protected $processLabel;
    /**
     * @var string
     */
    protected $appArmorProfile;
    /**
     * @var string
     */
    protected $execIDs;
    /**
     * Container configuration that depends on the host we are running on.
     *
     * @var HostConfig
     */
    protected $hostConfig;
    /**
     * Information about a container's graph driver.
     *
     * @var GraphDriverData
     */
    protected $graphDriver;
    /**
     * The size of files that have been created or changed by this container.
     *
     * @var int
     */
    protected $sizeRw;
    /**
     * The total size of all the files in this container.
     *
     * @var int
     */
    protected $sizeRootFs;
    /**
     * @var MountPoint[]
     */
    protected $mounts;
    /**
     * Configuration for a container that is portable between hosts.
     *
     * @var ContainerConfig
     */
    protected $config;
    /**
     * NetworkSettings exposes the network settings in the API.
     *
     * @var NetworkSettings
     */
    protected $networkSettings;

    /**
     * The ID of the container.
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * The ID of the container.
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * The time the container was created.
     *
     * @return string
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * The time the container was created.
     *
     * @param string $created
     *
     * @return self
     */
    public function setCreated(?string $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * The path to the command being run.
     *
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * The path to the command being run.
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * The arguments to the command being run.
     *
     * @return string[]
     */
    public function getArgs(): ?array
    {
        return $this->args;
    }

    /**
     * The arguments to the command being run.
     *
     * @param string[] $args
     *
     * @return self
     */
    public function setArgs(?array $args): self
    {
        $this->args = $args;

        return $this;
    }

    /**
     * The state of the container.
     *
     * @return ContainersIdJsonGetResponse200State
     */
    public function getState(): ?ContainersIdJsonGetResponse200State
    {
        return $this->state;
    }

    /**
     * The state of the container.
     *
     * @param ContainersIdJsonGetResponse200State $state
     *
     * @return self
     */
    public function setState(?ContainersIdJsonGetResponse200State $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * The container's image.
     *
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * The container's image.
     *
     * @param string $image
     *
     * @return self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getResolvConfPath(): ?string
    {
        return $this->resolvConfPath;
    }

    /**
     * @param string $resolvConfPath
     *
     * @return self
     */
    public function setResolvConfPath(?string $resolvConfPath): self
    {
        $this->resolvConfPath = $resolvConfPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostnamePath(): ?string
    {
        return $this->hostnamePath;
    }

    /**
     * @param string $hostnamePath
     *
     * @return self
     */
    public function setHostnamePath(?string $hostnamePath): self
    {
        $this->hostnamePath = $hostnamePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostsPath(): ?string
    {
        return $this->hostsPath;
    }

    /**
     * @param string $hostsPath
     *
     * @return self
     */
    public function setHostsPath(?string $hostsPath): self
    {
        $this->hostsPath = $hostsPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogPath(): ?string
    {
        return $this->logPath;
    }

    /**
     * @param string $logPath
     *
     * @return self
     */
    public function setLogPath(?string $logPath): self
    {
        $this->logPath = $logPath;

        return $this;
    }

    /**
     * TODO.
     *
     * @return mixed
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * TODO.
     *
     * @param mixed $node
     *
     * @return self
     */
    public function setNode($node): self
    {
        $this->node = $node;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getRestartCount(): ?int
    {
        return $this->restartCount;
    }

    /**
     * @param int $restartCount
     *
     * @return self
     */
    public function setRestartCount(?int $restartCount): self
    {
        $this->restartCount = $restartCount;

        return $this;
    }

    /**
     * @return string
     */
    public function getDriver(): ?string
    {
        return $this->driver;
    }

    /**
     * @param string $driver
     *
     * @return self
     */
    public function setDriver(?string $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return string
     */
    public function getMountLabel(): ?string
    {
        return $this->mountLabel;
    }

    /**
     * @param string $mountLabel
     *
     * @return self
     */
    public function setMountLabel(?string $mountLabel): self
    {
        $this->mountLabel = $mountLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getProcessLabel(): ?string
    {
        return $this->processLabel;
    }

    /**
     * @param string $processLabel
     *
     * @return self
     */
    public function setProcessLabel(?string $processLabel): self
    {
        $this->processLabel = $processLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getAppArmorProfile(): ?string
    {
        return $this->appArmorProfile;
    }

    /**
     * @param string $appArmorProfile
     *
     * @return self
     */
    public function setAppArmorProfile(?string $appArmorProfile): self
    {
        $this->appArmorProfile = $appArmorProfile;

        return $this;
    }

    /**
     * @return string
     */
    public function getExecIDs(): ?string
    {
        return $this->execIDs;
    }

    /**
     * @param string $execIDs
     *
     * @return self
     */
    public function setExecIDs(?string $execIDs): self
    {
        $this->execIDs = $execIDs;

        return $this;
    }

    /**
     * Container configuration that depends on the host we are running on.
     *
     * @return HostConfig
     */
    public function getHostConfig(): ?HostConfig
    {
        return $this->hostConfig;
    }

    /**
     * Container configuration that depends on the host we are running on.
     *
     * @param HostConfig $hostConfig
     *
     * @return self
     */
    public function setHostConfig(?HostConfig $hostConfig): self
    {
        $this->hostConfig = $hostConfig;

        return $this;
    }

    /**
     * Information about a container's graph driver.
     *
     * @return GraphDriverData
     */
    public function getGraphDriver(): ?GraphDriverData
    {
        return $this->graphDriver;
    }

    /**
     * Information about a container's graph driver.
     *
     * @param GraphDriverData $graphDriver
     *
     * @return self
     */
    public function setGraphDriver(?GraphDriverData $graphDriver): self
    {
        $this->graphDriver = $graphDriver;

        return $this;
    }

    /**
     * The size of files that have been created or changed by this container.
     *
     * @return int
     */
    public function getSizeRw(): ?int
    {
        return $this->sizeRw;
    }

    /**
     * The size of files that have been created or changed by this container.
     *
     * @param int $sizeRw
     *
     * @return self
     */
    public function setSizeRw(?int $sizeRw): self
    {
        $this->sizeRw = $sizeRw;

        return $this;
    }

    /**
     * The total size of all the files in this container.
     *
     * @return int
     */
    public function getSizeRootFs(): ?int
    {
        return $this->sizeRootFs;
    }

    /**
     * The total size of all the files in this container.
     *
     * @param int $sizeRootFs
     *
     * @return self
     */
    public function setSizeRootFs(?int $sizeRootFs): self
    {
        $this->sizeRootFs = $sizeRootFs;

        return $this;
    }

    /**
     * @return MountPoint[]
     */
    public function getMounts(): ?array
    {
        return $this->mounts;
    }

    /**
     * @param MountPoint[] $mounts
     *
     * @return self
     */
    public function setMounts(?array $mounts): self
    {
        $this->mounts = $mounts;

        return $this;
    }

    /**
     * Configuration for a container that is portable between hosts.
     *
     * @return ContainerConfig
     */
    public function getConfig(): ?ContainerConfig
    {
        return $this->config;
    }

    /**
     * Configuration for a container that is portable between hosts.
     *
     * @param ContainerConfig $config
     *
     * @return self
     */
    public function setConfig(?ContainerConfig $config): self
    {
        $this->config = $config;

        return $this;
    }

    /**
     * NetworkSettings exposes the network settings in the API.
     *
     * @return NetworkSettings
     */
    public function getNetworkSettings(): ?NetworkSettings
    {
        return $this->networkSettings;
    }

    /**
     * NetworkSettings exposes the network settings in the API.
     *
     * @param NetworkSettings $networkSettings
     *
     * @return self
     */
    public function setNetworkSettings(?NetworkSettings $networkSettings): self
    {
        $this->networkSettings = $networkSettings;

        return $this;
    }
}
