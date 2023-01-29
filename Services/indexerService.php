<?php
/**
 * @copyright Copyright (c) sbdevblog (http://www.sbdevblog.com)
 */

namespace SbDevBlog\Indexer\Services;

use Magento\Framework\Indexer\IndexerInterface;
use Magento\Indexer\Model\IndexerFactory;
use Magento\Indexer\Model\Indexer\Collection;
use Psr\Log\LoggerInterface;

class indexerService
{
    private const CATALOG_CATEGORY_PROD_INDXER = "catalog_category_product";
    /**
     * @var IndexerInterface
     */
    private IndexerInterface $indexer;

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var IndexerFactory
     */
    private IndexerFactory $indexerFactory;

    /**
     * Constructor For Service
     *
     * @param IndexerInterface $indexer
     * @param LoggerInterface $logger
     */
    public function __construct(
        IndexerInterface $indexer,
        Collection       $collection,
        IndexerFactory $indexerFactory,
        LoggerInterface  $logger
    )
    {
        $this->indexer = $indexer;
        $this->collection = $collection;
        $this->logger = $logger;
        $this->indexerFactory = $indexerFactory;
    }

    /**
     * Invalidate Index
     *
     * @return bool
     */
    public function invalidateCategryProductsIndex(): bool
    {
        try {
            $indexer = $this->getIndexerById(self::CATALOG_CATEGORY_PROD_INDXER);
            $indexer->invalidate();
            return true;
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
        }
        return false;
    }

    /**
     * Invalidate Indexer By Key
     *
     * @param string $indexerKey
     * @return bool
     */
    public function invalidateIndexById(string $indexerKey): bool
    {
        if (!$indexerKey) {
            return false;
        }
        try {
            $indexer = $this->getIndexerById($indexerKey);
            $indexer->invalidate();
            return true;
        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
        }
        return false;
    }

    /**
     * Re-index by id
     *
     * @param string $indexerKey
     * @return bool
     */
    public function reIndexById(string $indexerKey): bool
    {
        if (!$indexerKey) {
            return false;
        }
        try {
            $indexer = $this->getIndexerById($indexerKey);
            $indexer->reindexAll();
            return true;
        } catch (\InvalidArgumentException|\Exception $e) {
            $this->logger->error($e->getMessage());
        }
        return false;
    }

    /**
     * Get Indexer by id
     *
     * @param string $indexerKey
     * @return IndexerInterface
     */
    private function getIndexerById(string $indexerKey): IndexerInterface
    {
        return $this->indexer->load($indexerKey);
    }

    /**
     * Reindex all s
     * @return void
     */
    public function reindexAllIndexer()
    {
        $indexes = $this->collection->getAllIds();
        try {
            foreach ($indexes as $index) {
                $indexer = $this->indexerFactory->create()->load($index);

                $indexer->reindexAll();

            }
        }catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * ReIndex Category Product Indexer
     *
     * @return void
     */
    public function reIndexCatProdId()
    {
        $indexer = $this->getIndexerById(self::CATALOG_CATEGORY_PROD_INDXER);
        try {
            $indexer->reindexAll();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
