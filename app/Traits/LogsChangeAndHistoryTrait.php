<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait LogsChangeAndHistoryTrait
{
    /**
     * Save changes, log them, and record the history.
     *
     * @param array $attributes
     * @return bool
     */
    public function saveChangesAndRecordHistory(array $attributes = [], $action,$user)
    {
        // Update model attributes
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }

        // Check if there are any changes
        if ($this->isDirty()) {
            $original = $this->getOriginal();
            $changes = $this->getDirty();

            // Save changes to the main table
            $saved = $this->save(); 

         if ($saved) {
                // Handle change logging
                $this->logChanges($original, $changes,  $action,$user);

                // Handle history recording
                $this->recordHistory( $action,$user);
            }

            return  $saved;
        }

        // No changes were detected
        return false;
    }

    /**
     * Log incremental changes to the change log table.
     *
     * @param array $original
     * @param array $changes
     * @return void
     */
    protected function logChanges(array $original, array $changes,$action,$user)
    {
        logger()->debug(" trait LogsChangeAndHistoryTrait logChanges : done" . var_export($changes, true));
        $conn = $this->getConnectionName();
        $logTableName = $this->getTable() . '_change_log';

        // Ensure the log table exists
        if (Schema::connection($conn)->hasTable($logTableName)) {
            foreach ($changes as $field => $newValue) {
                DB::connection($conn)->table($logTableName)->insert([
                    'id' => $this->id,
                    'fieldname' => $field,
                    'orgvalue' => $original[$field] ?? null,
                    'newvalue' => $newValue,
                    'action' => $action,
                    'created_by' => $user,
                    'created_at' => now(),
                ]);
            }
        }
    }

    /**
     * Record the full snapshot of the current state to the history table.
     *
     * @return void
     */
    protected function recordHistory($action,$user)
    {
        $historyTableName = $this->getTable() . '_history';
        $conn = $this->getConnectionName();
        // Ensure the history table exists
        if (Schema::connection($conn)->hasTable($historyTableName)) {
            $snapshot = $this->toArray();
            $snapshot['id'] = $this->id;
            $snapshot['log_action'] = $action;
            $snapshot['logged_by'] = $user;
            $snapshot['logged_at'] = now();

            // may consider Remove the primary key from the snapshot to avoid conflicts
            //unset($snapshot['id']);

            DB::connection($conn)->table($historyTableName)->insert($snapshot);
        }
    }
}
