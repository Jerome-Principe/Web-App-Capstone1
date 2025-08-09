<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MembershipRenewal;
use App\Models\PendingMembership;
use App\Models\RequestMembership;

class FixMembershipTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:fix-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix membership types for members who have approved renewals but inconsistent data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting membership type fix...');

        try {
            // Get all approved renewals
            $approvedRenewals = MembershipRenewal::where('status', 'Approved')
                ->with(['pendingMembership', 'pendingMembership.requestMembership'])
                ->get();

            $updatedCount = 0;

            foreach ($approvedRenewals as $renewal) {
                $pendingMembership = $renewal->pendingMembership;
                $requestMembership = $pendingMembership?->requestMembership;

                if (!$pendingMembership || !$requestMembership) {
                    $this->warn("Skipping renewal ID {$renewal->id} - missing related records");
                    continue;
                }

                $renewalType = strtolower($renewal->membership_type);
                $currentPendingType = strtolower($pendingMembership->membership_type ?? '');
                $currentRequestType = strtolower($requestMembership->membership_type ?? '');

                $needsUpdate = false;

                // Check if pending_memberships table needs update
                if ($currentPendingType !== $renewalType) {
                    $pendingMembership->update(['membership_type' => $renewal->membership_type]);
                    $needsUpdate = true;
                    $this->info("Updated pending_memberships.membership_type for membership ID {$pendingMembership->id}: {$currentPendingType} -> {$renewalType}");
                }

                // Check if request_memberships table needs update
                if ($currentRequestType !== $renewalType) {
                    $requestMembership->update(['membership_type' => $renewal->membership_type]);
                    $needsUpdate = true;
                    $this->info("Updated request_memberships.membership_type for membership ID {$pendingMembership->id}: {$currentRequestType} -> {$renewalType}");
                }

                if ($needsUpdate) {
                    $updatedCount++;
                }
            }

            $this->info("Membership type fix completed!");
            $this->info("Total memberships updated: {$updatedCount}");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Error fixing membership types: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
