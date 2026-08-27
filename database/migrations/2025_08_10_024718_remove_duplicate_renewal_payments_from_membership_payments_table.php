<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove payment records that were created from approved membership renewals
        // to eliminate duplicate data in the payment list

        // Get membership IDs that have approved renewals
        $approvedRenewalMembershipIds = DB::table('membership_renewals')
            ->where('status', 'Approved')
            ->pluck('membership_id')
            ->unique()
            ->toArray();

        if (!empty($approvedRenewalMembershipIds)) {
            // Delete payment records for memberships that have approved renewals
            $deletedCount = DB::table('membership_payments')
                ->whereIn('membership_id', $approvedRenewalMembershipIds)
                ->delete();

            echo "Removed {$deletedCount} duplicate payment records for memberships with approved renewals.\n";
        } else {
            echo "No duplicate payment records found to remove.\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: We cannot restore the deleted payment records as they were duplicates
        // The original renewal payment data still exists in the membership_renewals table
        echo "Cannot restore deleted duplicate payment records. Original data remains in membership_renewals table.\n";
    }
};
