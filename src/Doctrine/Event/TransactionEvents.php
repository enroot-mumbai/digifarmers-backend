<?php

namespace App\Doctrine\Event;

final class TransactionEvents
{
    /**
     * Private constructor. This class is not meant to be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * The postCommit event occurs when a transaction has been completed successfully.
     *
     * @var string
     */
    const postCommit = 'onPostCommit';

    /**
     * The postRollback event occurs when a transaction has failed.
     *
     * @var string
     */
    const postRollback = 'onPostRollback';
}