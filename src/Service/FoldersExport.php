<?php


namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class FoldersExport
{

    private EntityManagerInterface $entityManager;

    private LoggerInterface $logger;

    private string $fromFolders;

    private string $exportDirectory;

    /**
     * FoldersExport constructor.
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     * @param string $exportDirectory
     * @param string $fromFolders
     */

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        string $exportDirectory,
        string $fromFolders
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->exportDirectory = $exportDirectory;
        $this->fromFolders = $fromFolders;
    }


    public function export(?string $destination = null, int $idFolder = null, string $username = null): ?string
    {
        $repository = $this->entityManager->getRepository(User::class);
        $criteria = [];
        $user = null;
        if (null !== $idFolder) {
            $criteria['id'] = $idFolder;
        }
        if (null !== $username) {
            $criteria['username'] = $username;
        }
        if (!!$criteria) {
            $user = $repository->findOneBy($criteria);
        }
        if (null === $user) {
            throw new \Exception("No user found");
        }

        return $this->collectArchiveFiles($user->getFiles(), $destination);;
    }

    public function collectArchiveFiles(object $files = null, ?string $destination = null)
    {
        $zipArchive = new \ZipArchive();
        $filesystem = new Filesystem();

        if (0 >= count($files)) {
            throw new \InvalidArgumentException("Bad argument, no object, null object ");
        }
        if (null === $destination) {
            $destination = $this->exportDirectory.DIRECTORY_SEPARATOR.'export_dossiers_'.date('YmdHis').'.zip';
        }

        $filesystem->remove($destination);
        $success = $zipArchive->open($destination, \ZipArchive::CREATE);

        if (true !== $success) {
            throw new \Exception("Cannot create ".$destination);
        }
        foreach ($files as $file) {
            $fromFile = $this->fromFolders.DIRECTORY_SEPARATOR.$file->getFolderId(
                ).DIRECTORY_SEPARATOR.$file->getFileName();

            $filename = 'dossiers_export'.DIRECTORY_SEPARATOR.$file->getFileName();
            $zipArchive->addFile($fromFile, $filename);
        }
        $zipArchive->close();

        return $destination;
    }
}