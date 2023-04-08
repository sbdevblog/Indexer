<?php
/**
 * @copyright Copyright (c) sbdevblog (http://www.sbdevblog.com)
 */

namespace SbDevBlog\Indexer\Model\Indexer;

use Magento\Framework\Indexer\ActionInterface;

class SbDevBlogIndexer implements ActionInterface, \Magento\Framework\Mview\ActionInterface
{

    /**
     * @inheritDoc
     */
    public function executeFull()
    {
        // Will take all of the data and reindex
        // Will run when reindex via command line
    }

    /**
     * @inheritDoc
     */
    public function executeList(array $ids)
    {
        //Works with a set of entity changed (E.G massaction)
    }

    /**
     * @inheritDoc
     */
    public function executeRow($id)
    {
        // Works in runtime for a single entity using plugins
    }

    public function execute($ids)
    {
        // Used by mview, allows process indexer in the "Update on schedule" mode
    }
}
