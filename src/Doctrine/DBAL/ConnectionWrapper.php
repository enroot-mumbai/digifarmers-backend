<?php

namespace App\Doctrine\DBAL;

use Doctrine\DBAL\Connection;

use App\Doctrine\Event\PostCommitEventArgs;
use App\Doctrine\Event\PostRollbackEventArgs;
use App\Doctrine\Event\TransactionEvents;

class ConnectionWrapper extends Connection
{
    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        parent::commit();

        if (!$this->isTransactionActive()) { // to be sure that we are committing a top-level transaction
            $this->getEventManager()->dispatchEvent(TransactionEvents::postCommit, new PostCommitEventArgs());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack()
    {
        parent::rollBack();

        if (!$this->isTransactionActive()) { // to be sure that we are rolling-back a top-level transaction
            $this->getEventManager()->dispatchEvent(TransactionEvents::postRollback, new PostRollbackEventArgs());
        }
    }
}