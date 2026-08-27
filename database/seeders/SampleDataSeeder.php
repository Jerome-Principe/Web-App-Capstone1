<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\AttendanceRecord;
use App\Models\Competition;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Expense;
use App\Models\Feedback;
use App\Models\Goal;
use App\Models\Instructor;
use App\Models\MealPlan;
use App\Models\MembershipPayment;
use App\Models\PendingAppointment;
use App\Models\PendingMembership;
use App\Models\RequestMembership;
use App\Models\StockItem;
use App\Models\User;
use App\Models\Walkin;
use App\Models\WorkoutProgram;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * FITDROID sample data for local development / demos.
 *
 * Default password for all sample admin users: Fitdroid@2026
 *
 * Run: php artisan db:seed --class=SampleDataSeeder
 */
class SampleDataSeeder extends Seeder
{
    private const SAMPLE_PASSWORD = 'Fitdroid@2026';

    public function run(): void
    {
        $today = Carbon::parse('2026-05-31');

        $this->seedAdminUsers();
        $instructors = $this->seedInstructors();
        $members = $this->seedMemberships($today);
        $this->seedAnnouncements();
        $this->seedAppointments($instructors, $members, $today);
        $this->seedAttendance($members, $today);
        $this->seedWalkins($today);
        $this->seedExpenses($today);
        $this->seedGoals();
        $this->seedCompetitions();
        $this->seedFeedback();
        $this->seedInventory();
        $this->seedEquipments();
        $this->seedResources();
        $this->seedMembershipPayments($members);
    }

    private function seedAdminUsers(): void
    {
        $users = [
            ['name' => 'Maria Santos', 'email' => 'maria.santos@fitdroid.local', 'role' => 'Admin'],
            ['name' => 'Jerome Principe', 'email' => 'jerome.principe@fitdroid.local', 'role' => 'Admin'],
            ['name' => 'Ana Dela Cruz', 'email' => 'ana.delacruz@fitdroid.local', 'role' => 'Admin'],
            ['name' => 'Rico Mendoza', 'email' => 'rico.mendoza@fitdroid.local', 'role' => 'Cashier'],
            ['name' => 'Liza Fernandez', 'email' => 'liza.fernandez@fitdroid.local', 'role' => 'Cashier'],
            ['name' => 'Mark Villanueva', 'email' => 'mark.villanueva@fitdroid.local', 'role' => 'Cashier'],
            ['name' => 'Coach Paolo Reyes', 'email' => 'paolo.reyes@fitdroid.local', 'role' => 'Instructor'],
            ['name' => 'Coach Nina Torres', 'email' => 'nina.torres@fitdroid.local', 'role' => 'Instructor'],
            ['name' => 'Coach Miguel Ramos', 'email' => 'miguel.ramos@fitdroid.local', 'role' => 'Instructor'],
            ['name' => 'Coach Sofia Lim', 'email' => 'sofia.lim@fitdroid.local', 'role' => 'Instructor'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make(self::SAMPLE_PASSWORD),
                    'role' => $user['role'],
                    'email_verified_at' => now(),
                    'profile_picture' => null,
                ]
            );
        }
    }

    /** @return \Illuminate\Support\Collection<int, Instructor> */
    private function seedInstructors()
    {
        $data = [
            ['first_name' => 'Paolo', 'last_name' => 'Reyes', 'contact_number' => '09171234501', 'expertise' => 'Strength Training', 'session' => 'Morning', 'rates' => 500],
            ['first_name' => 'Nina', 'last_name' => 'Torres', 'contact_number' => '09171234502', 'expertise' => 'Yoga & Mobility', 'session' => 'Afternoon', 'rates' => 450],
            ['first_name' => 'Miguel', 'last_name' => 'Ramos', 'contact_number' => '09171234503', 'expertise' => 'HIIT & Cardio', 'session' => 'Evening', 'rates' => 480],
            ['first_name' => 'Sofia', 'last_name' => 'Lim', 'contact_number' => '09171234504', 'expertise' => 'CrossFit', 'session' => 'Morning', 'rates' => 550],
            ['first_name' => 'Diego', 'last_name' => 'Castillo', 'contact_number' => '09171234505', 'expertise' => 'Bodybuilding', 'session' => 'Evening', 'rates' => 520],
            ['first_name' => 'Hannah', 'last_name' => 'Gomez', 'contact_number' => '09171234506', 'expertise' => 'Pilates', 'session' => 'Afternoon', 'rates' => 470],
            ['first_name' => 'Aaron', 'last_name' => 'Navarro', 'contact_number' => '09171234507', 'expertise' => 'Boxing Fitness', 'session' => 'Morning', 'rates' => 500],
            ['first_name' => 'Bianca', 'last_name' => 'Flores', 'contact_number' => '09171234508', 'expertise' => 'Functional Training', 'session' => 'Evening', 'rates' => 490],
            ['first_name' => 'Ethan', 'last_name' => 'Santos', 'contact_number' => '09171234509', 'expertise' => 'Weight Loss Coaching', 'session' => 'Afternoon', 'rates' => 460],
            ['first_name' => 'Chloe', 'last_name' => 'Aquino', 'contact_number' => '09171234510', 'expertise' => 'Senior Fitness', 'session' => 'Morning', 'rates' => 440],
        ];

        return collect($data)->map(fn($row) => Instructor::create($row));
    }

    /** @return \Illuminate\Support\Collection<int, PendingMembership> */
    private function seedMemberships(Carbon $today)
    {
        $types = ['Bronze', 'Silver', 'Gold', 'Bronze', 'Silver', 'Gold', 'Bronze', 'Silver', 'Gold', 'Bronze'];
        $members = collect();

        foreach ($types as $i => $type) {
            $num = $i + 1;
            $start = $today->copy()->subDays(rand(5, 60));
            $expiry = match (strtolower($type)) {
                'gold' => $start->copy()->addMonths(6),
                'silver' => $start->copy()->addMonths(3),
                default => $start->copy()->addMonth(),
            };

            $member = PendingMembership::updateOrCreate(
                ['email' => "member{$num}@fitdroid.local"],
                [
                    'first_name' => ['Juan', 'Maria', 'Carlos', 'Angela', 'Kevin', 'Patricia', 'James', 'Rachel', 'Daniel', 'Nicole'][$i],
                    'last_name' => ['Reyes', 'Lopez', 'Garcia', 'Cruz', 'Tan', 'Rivera', 'Santos', 'Diaz', 'Morales', 'Bautista'][$i],
                    'password' => Hash::make(self::SAMPLE_PASSWORD),
                    'status' => 'Approved',
                    'membership_type' => $type,
                    'start_date' => $start->format('Y-m-d'),
                    'expiry_date' => $expiry->format('Y-m-d'),
                ]
            );

            RequestMembership::updateOrCreate(
                ['email' => $member->email],
                [
                    'membership_id' => $member->id,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'middle_name' => 'M',
                    'date' => $start->format('Y-m-d'),
                    'gender' => $i % 2 === 0 ? 'Male' : 'Female',
                    'age' => 20 + $i,
                    'weight' => 60 + $i,
                    'height' => 165 + $i,
                    'address' => "{$num} Fitness Street, Quezon City",
                    'postal_code' => '1100',
                    'work' => 'Office Worker',
                    'mobile' => '091800000' . str_pad((string) $num, 2, '0', STR_PAD_LEFT),
                    'gym_source' => 'Social Media',
                    'membership_type' => $type,
                ]
            );

            $members->push($member);
        }

        return $members;
    }

    private function seedAnnouncements(): void
    {
        $items = [
            ['notification_text' => 'Gym Holiday Schedule – June 12', 'description' => 'FITDROID will operate on a shortened schedule (6 AM–2 PM) on June 12 for Independence Day. Evening classes are cancelled.'],
            ['notification_text' => 'New Gold Membership Perks', 'description' => 'Gold members now receive one free PT session per month and 10% off supplement purchases at the front desk.'],
            ['notification_text' => 'Equipment Maintenance – Cardio Zone', 'description' => 'Treadmills 3–5 will be serviced on June 2, 8 AM–12 PM. Please use alternate machines during this window.'],
            ['notification_text' => 'Summer Bootcamp Registration Open', 'description' => 'Sign up at the front desk for our 4-week Summer Shred bootcamp starting June 15. Limited slots for 20 participants.'],
            ['notification_text' => 'Peak Hours Reminder', 'description' => 'Our busiest times are 6–9 AM and 5–8 PM. Arrive early or consider off-peak slots for a smoother workout.'],
            ['notification_text' => 'Refer-a-Friend Promo', 'description' => 'Refer a friend who joins any paid membership and both receive ₱200 off your next renewal. Valid until July 31, 2026.'],
            ['notification_text' => 'Hydration Stations Upgraded', 'description' => 'We installed new filtered water stations near the locker rooms. Bring your own bottle to help reduce plastic waste.'],
            ['notification_text' => 'Instructor Spotlight: Coach Nina', 'description' => 'Join Coach Nina every Tuesday and Thursday at 4 PM for Yoga Flow. Open to all membership tiers.'],
            ['notification_text' => 'Safety Drill – June 5', 'description' => 'A brief fire and emergency evacuation drill will run at 10 AM. Please follow staff instructions if you are on the floor.'],
            ['notification_text' => 'Mobile App Update Available', 'description' => 'Update the FITDROID member app to book appointments faster and view your attendance history. Ask staff if you need help logging in.'],
        ];

        foreach ($items as $item) {
            Announcement::create($item);
        }
    }

    private function seedAppointments($instructors, $members, Carbon $today): void
    {
        $statuses = ['Approved', 'Approved', 'Pending', 'Approved', 'Pending', 'Approved', 'Approved', 'Pending', 'Approved', 'Approved'];
        $times = ['08:00 AM', '09:30 AM', '11:00 AM', '02:00 PM', '03:30 PM', '05:00 PM', '06:30 PM', '07:00 PM', '10:00 AM', '04:00 PM'];
        $dates = [
            $today->format('Y-m-d'),
            $today->format('Y-m-d'),
            $today->copy()->addDay()->format('Y-m-d'),
            $today->format('Y-m-d'),
            $today->copy()->addDays(2)->format('Y-m-d'),
            $today->format('Y-m-d'),
            $today->copy()->subDay()->format('Y-m-d'),
            $today->copy()->addDay()->format('Y-m-d'),
            $today->format('Y-m-d'),
            $today->copy()->addDays(3)->format('Y-m-d'),
        ];

        foreach ($members as $i => $member) {
            $instructor = $instructors[$i % $instructors->count()];
            $instructorRate = (float) $instructor->rates;
            $gymRate = 200.00;
            PendingAppointment::create([
                'instructor_id' => $instructor->id,
                'user_id' => $member->id,
                'selected_date' => $dates[$i],
                'selected_time' => $times[$i],
                'payment_method' => $i % 2 === 0 ? 'GCash' : 'Cash',
                'gcash_account_name' => $i % 2 === 0 ? $member->first_name . ' ' . $member->last_name : null,
                'gcash_account_number' => $i % 2 === 0 ? '0917123000' . $i : null,
                'proof_of_payment' => null,
                'status' => $statuses[$i],
                'instructor_rate' => $instructorRate,
                'gym_rate' => $gymRate,
                'total_amount' => $instructorRate + $gymRate,
            ]);
        }
    }

    private function seedAttendance($members, Carbon $today): void
    {
        foreach ($members as $i => $member) {
            $name = $member->first_name . ' ' . $member->last_name;
            $rfid = 'RFID' . str_pad((string) ($i + 1), 6, '0', STR_PAD_LEFT);
            $logDate = $i < 6 ? $today : $today->copy()->subDays($i - 5);

            AttendanceRecord::create([
                'username' => $name,
                'rfid' => $rfid,
                'time_in' => sprintf('%02d:%02d:00', 6 + ($i % 4), ($i * 7) % 60),
                'time_out' => sprintf('%02d:%02d:00', 8 + ($i % 3), ($i * 11) % 60),
                'date_logged' => $logDate->format('Y-m-d'),
            ]);
        }
    }

    private function seedWalkins(Carbon $today): void
    {
        $walkins = [
            ['lastname' => 'Dizon', 'firstname' => 'Leo', 'middlename' => 'A', 'gender' => 'Male', 'age' => 24, 'city' => 'Quezon City', 'province' => 'Metro Manila', 'zipcode' => '1100', 'amount' => 150, 'payment' => 'Cash'],
            ['lastname' => 'Pascual', 'firstname' => 'Mia', 'middlename' => 'B', 'gender' => 'Female', 'age' => 28, 'city' => 'Makati', 'province' => 'Metro Manila', 'zipcode' => '1200', 'amount' => 150, 'payment' => 'GCash'],
            ['lastname' => 'Ocampo', 'firstname' => 'Ryan', 'middlename' => 'C', 'gender' => 'Male', 'age' => 32, 'city' => 'Pasig', 'province' => 'Metro Manila', 'zipcode' => '1600', 'amount' => 200, 'payment' => 'Cash'],
            ['lastname' => 'Velasco', 'firstname' => 'Ella', 'middlename' => 'D', 'gender' => 'Female', 'age' => 21, 'city' => 'Manila', 'province' => 'Metro Manila', 'zipcode' => '1000', 'amount' => 150, 'payment' => 'Cash'],
            ['lastname' => 'Ignacio', 'firstname' => 'Noah', 'middlename' => 'E', 'gender' => 'Male', 'age' => 35, 'city' => 'Taguig', 'province' => 'Metro Manila', 'zipcode' => '1630', 'amount' => 150, 'payment' => 'GCash'],
            ['lastname' => 'Salazar', 'firstname' => 'Ivy', 'middlename' => 'F', 'gender' => 'Female', 'age' => 26, 'city' => 'Quezon City', 'province' => 'Metro Manila', 'zipcode' => '1102', 'amount' => 150, 'payment' => 'Cash'],
            ['lastname' => 'Domingo', 'firstname' => 'Kyle', 'middlename' => 'G', 'gender' => 'Male', 'age' => 29, 'city' => 'Caloocan', 'province' => 'Metro Manila', 'zipcode' => '1400', 'amount' => 200, 'payment' => 'Cash'],
            ['lastname' => 'Mercado', 'firstname' => 'Zoe', 'middlename' => 'H', 'gender' => 'Female', 'age' => 23, 'city' => 'Mandaluyong', 'province' => 'Metro Manila', 'zipcode' => '1550', 'amount' => 150, 'payment' => 'GCash'],
            ['lastname' => 'Fabian', 'firstname' => 'Owen', 'middlename' => 'I', 'gender' => 'Male', 'age' => 31, 'city' => 'Parañaque', 'province' => 'Metro Manila', 'zipcode' => '1700', 'amount' => 150, 'payment' => 'Cash'],
            ['lastname' => 'Castro', 'firstname' => 'Ava', 'middlename' => 'J', 'gender' => 'Female', 'age' => 27, 'city' => 'Las Piñas', 'province' => 'Metro Manila', 'zipcode' => '1740', 'amount' => 150, 'payment' => 'Cash'],
        ];

        foreach ($walkins as $i => $row) {
            $visitDate = $i < 4 ? $today : $today->copy()->subDays($i - 3);
            Walkin::create(array_merge($row, [
                'date' => $visitDate->format('Y-m-d'),
                'time' => sprintf('%02d:%02d:00', 7 + ($i % 5), ($i * 13) % 60),
            ]));
        }
    }

    private function seedExpenses(Carbon $today): void
    {
        $expenses = [
            ['expense_description' => 'Monthly gym rent', 'amount' => 45000, 'payment_method' => 'Bank Transfer'],
            ['expense_description' => 'Meralco electricity bill', 'amount' => 12850.50, 'payment_method' => 'GCash'],
            ['expense_description' => 'Maynilad water bill', 'amount' => 2340.00, 'payment_method' => 'Cash'],
            ['expense_description' => 'Protein supplements restock', 'amount' => 18500, 'payment_method' => 'Bank Transfer'],
            ['expense_description' => 'Treadmill belt replacement', 'amount' => 7600, 'payment_method' => 'Cash'],
            ['expense_description' => 'Cleaning supplies & sanitizers', 'amount' => 3200, 'payment_method' => 'GCash'],
            ['expense_description' => 'Staff uniforms', 'amount' => 5400, 'payment_method' => 'Cash'],
            ['expense_description' => 'Facebook & Instagram ads', 'amount' => 5000, 'payment_method' => 'GCash'],
            ['expense_description' => 'Wi-Fi & security cameras', 'amount' => 4100, 'payment_method' => 'Bank Transfer'],
            ['expense_description' => 'First-aid & gym towels laundry', 'amount' => 1850, 'payment_method' => 'Cash'],
        ];

        foreach ($expenses as $i => $row) {
            Expense::create(array_merge($row, [
                'date' => $today->copy()->subDays($i)->format('Y-m-d'),
            ]));
        }
    }

    private function seedGoals(): void
    {
        $goals = [
            ['name' => 'Juan Reyes', 'status' => 'Active', 'starting_weight' => 82, 'current_weight' => 78.5, 'goal_weight' => 75, 'weekly_goal' => 0.5, 'activity' => 'Moderate'],
            ['name' => 'Maria Lopez', 'status' => 'Active', 'starting_weight' => 68, 'current_weight' => 65, 'goal_weight' => 62, 'weekly_goal' => 0.4, 'activity' => 'Light'],
            ['name' => 'Carlos Garcia', 'status' => 'Completed', 'starting_weight' => 95, 'current_weight' => 88, 'goal_weight' => 88, 'weekly_goal' => 0.6, 'activity' => 'High'],
            ['name' => 'Angela Cruz', 'status' => 'Active', 'starting_weight' => 58, 'current_weight' => 56, 'goal_weight' => 54, 'weekly_goal' => 0.3, 'activity' => 'Moderate'],
            ['name' => 'Kevin Tan', 'status' => 'Paused', 'starting_weight' => 76, 'current_weight' => 74, 'goal_weight' => 70, 'weekly_goal' => 0.5, 'activity' => 'Moderate'],
            ['name' => 'Patricia Rivera', 'status' => 'Active', 'starting_weight' => 71, 'current_weight' => 69, 'goal_weight' => 65, 'weekly_goal' => 0.45, 'activity' => 'High'],
            ['name' => 'James Santos', 'status' => 'Active', 'starting_weight' => 88, 'current_weight' => 85, 'goal_weight' => 80, 'weekly_goal' => 0.55, 'activity' => 'High'],
            ['name' => 'Rachel Diaz', 'status' => 'Active', 'starting_weight' => 63, 'current_weight' => 61.5, 'goal_weight' => 58, 'weekly_goal' => 0.35, 'activity' => 'Light'],
            ['name' => 'Daniel Morales', 'status' => 'Active', 'starting_weight' => 90, 'current_weight' => 87, 'goal_weight' => 82, 'weekly_goal' => 0.5, 'activity' => 'Moderate'],
            ['name' => 'Nicole Bautista', 'status' => 'Active', 'starting_weight' => 55, 'current_weight' => 54, 'goal_weight' => 52, 'weekly_goal' => 0.25, 'activity' => 'Light'],
        ];

        $start = Carbon::parse('2026-01-15');
        foreach ($goals as $i => $row) {
            Goal::create(array_merge($row, [
                'starting_date' => $start->copy()->addDays($i * 5)->format('Y-m-d'),
            ]));
        }
    }

    private function seedCompetitions(): void
    {
        $entries = [
            ['name' => 'Juan Reyes', 'age' => 28, 'gender' => 'Male', 'height' => 175, 'weight' => 78.5, 'type_of_competition' => 'Bench Press'],
            ['name' => 'Maria Lopez', 'age' => 25, 'gender' => 'Female', 'height' => 162, 'weight' => 65, 'type_of_competition' => 'Deadlift'],
            ['name' => 'Carlos Garcia', 'age' => 32, 'gender' => 'Male', 'height' => 180, 'weight' => 88, 'type_of_competition' => 'Squat'],
            ['name' => 'Angela Cruz', 'age' => 24, 'gender' => 'Female', 'height' => 158, 'weight' => 56, 'type_of_competition' => 'Plank Hold'],
            ['name' => 'Kevin Tan', 'age' => 30, 'gender' => 'Male', 'height' => 172, 'weight' => 74, 'type_of_competition' => 'Pull-up Challenge'],
            ['name' => 'Patricia Rivera', 'age' => 27, 'gender' => 'Female', 'height' => 165, 'weight' => 69, 'type_of_competition' => '5K Treadmill'],
            ['name' => 'James Santos', 'age' => 35, 'gender' => 'Male', 'height' => 178, 'weight' => 85, 'type_of_competition' => 'Strongman Carry'],
            ['name' => 'Rachel Diaz', 'age' => 23, 'gender' => 'Female', 'height' => 160, 'weight' => 61.5, 'type_of_competition' => 'Burpee AMRAP'],
            ['name' => 'Daniel Morales', 'age' => 29, 'gender' => 'Male', 'height' => 182, 'weight' => 87, 'type_of_competition' => 'Clean & Jerk'],
            ['name' => 'Nicole Bautista', 'age' => 22, 'gender' => 'Female', 'height' => 155, 'weight' => 54, 'type_of_competition' => 'Bike Sprint'],
        ];

        foreach ($entries as $row) {
            Competition::create($row);
        }
    }

    private function seedFeedback(): void
    {
        $items = [
            ['name' => 'Juan Reyes', 'email' => 'member1@fitdroid.local', 'subject' => 'Great trainers', 'message' => 'Coach Paolo helped me fix my squat form. Very professional and encouraging.'],
            ['name' => 'Maria Lopez', 'email' => 'member2@fitdroid.local', 'subject' => 'Locker room cleanliness', 'message' => 'Could we have more hooks and a second hair dryer in the women\'s locker room during peak hours?'],
            ['name' => 'Walk-in Guest', 'email' => 'leo.dizon@email.com', 'subject' => 'Day pass experience', 'message' => 'Smooth check-in at the front desk. Would consider a Bronze membership next month.'],
            ['name' => 'Carlos Garcia', 'email' => 'member3@fitdroid.local', 'subject' => 'App booking', 'message' => 'Appointment booking in the app is easy. Please add calendar reminders.'],
            ['name' => 'Angela Cruz', 'email' => 'member4@fitdroid.local', 'subject' => 'Music volume', 'message' => 'Love the energy but the main floor music is a bit loud after 7 PM.'],
            ['name' => 'Kevin Tan', 'email' => 'member5@fitdroid.local', 'subject' => 'Equipment request', 'message' => 'Any chance to add another power rack? Wait times get long on weekends.'],
            ['name' => 'Patricia Rivera', 'email' => 'member6@fitdroid.local', 'subject' => 'Yoga classes', 'message' => 'Coach Nina\'s yoga sessions are the highlight of my week. Please keep the Tuesday slot.'],
            ['name' => 'James Santos', 'email' => 'member7@fitdroid.local', 'subject' => 'Parking', 'message' => 'Suggest partnering with the building next door for discounted parking for members.'],
            ['name' => 'Rachel Diaz', 'email' => 'member8@fitdroid.local', 'subject' => 'Supplement prices', 'message' => 'Competitive prices at the counter. Loyalty points would be a nice bonus.'],
            ['name' => 'Daniel Morales', 'email' => 'member9@fitdroid.local', 'subject' => 'Overall experience', 'message' => 'FITDROID feels modern and welcoming. Keep up the great community events.'],
        ];

        foreach ($items as $row) {
            Feedback::create($row);
        }
    }

    private function seedInventory(): void
    {
        $items = [
            ['item_name' => 'Whey Protein 2lb (Chocolate)', 'quantity' => 24, 'price' => 1899],
            ['item_name' => 'Pre-Workout 30 servings', 'quantity' => 15, 'price' => 1299],
            ['item_name' => 'BCAA Powder', 'quantity' => 8, 'price' => 999],
            ['item_name' => 'Resistance Bands Set', 'quantity' => 20, 'price' => 450],
            ['item_name' => 'Shaker Bottle 700ml', 'quantity' => 35, 'price' => 199],
            ['item_name' => 'Gym Towel (FITDROID branded)', 'quantity' => 5, 'price' => 250],
            ['item_name' => 'Creatine Monohydrate 300g', 'quantity' => 12, 'price' => 799],
            ['item_name' => 'Lifting Straps', 'quantity' => 18, 'price' => 350],
            ['item_name' => 'Electrolyte Drink (500ml)', 'quantity' => 40, 'price' => 65],
            ['item_name' => 'Mass Gainer 6lb', 'quantity' => 6, 'price' => 2499],
        ];

        $date = Carbon::parse('2026-05-31')->format('Y-m-d');
        foreach ($items as $row) {
            StockItem::create([
                'item_name' => $row['item_name'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'total' => $row['quantity'] * $row['price'],
                'date' => $date,
            ]);
        }
    }

    private function seedEquipments(): void
    {
        $items = [
            ['item_name' => 'Adjustable Dumbbells (pair)', 'quantity' => 10],
            ['item_name' => 'Olympic Barbell 20kg', 'quantity' => 6],
            ['item_name' => 'Power Rack', 'quantity' => 3],
            ['item_name' => 'Flat Bench', 'quantity' => 8],
            ['item_name' => 'Cable Machine', 'quantity' => 2],
            ['item_name' => 'Treadmill', 'quantity' => 5],
            ['item_name' => 'Spin Bike', 'quantity' => 4],
            ['item_name' => 'Kettlebell 16kg', 'quantity' => 12],
            ['item_name' => 'Medicine Ball 10kg', 'quantity' => 6],
            ['item_name' => 'Foam Roller', 'quantity' => 10],
        ];

        $date = Carbon::parse('2026-05-31')->format('Y-m-d');
        foreach ($items as $row) {
            Equipment::create(array_merge($row, ['date' => $date]));
        }
    }

    private function seedResources(): void
    {
        $exercises = [
            ['category' => 'Strength', 'type' => 'Upper Body', 'guideline' => 'Warm up 5–10 minutes before lifting.', 'exercise' => 'Bench Press', 'description' => 'Flat bench, controlled tempo.', 'duration' => '45 min'],
            ['category' => 'Strength', 'type' => 'Lower Body', 'guideline' => 'Keep core braced on every rep.', 'exercise' => 'Barbell Squat', 'description' => 'Depth to parallel or below.', 'duration' => '50 min'],
            ['category' => 'Cardio', 'type' => 'HIIT', 'guideline' => 'Alternate work and rest intervals.', 'exercise' => 'Sprint Intervals', 'description' => '30 sec on / 30 sec off.', 'duration' => '25 min'],
            ['category' => 'Mobility', 'type' => 'Recovery', 'guideline' => 'Breathe slowly through each stretch.', 'exercise' => 'Hip Flexor Stretch', 'description' => 'Hold 30 seconds each side.', 'duration' => '15 min'],
            ['category' => 'Core', 'type' => 'Abs', 'guideline' => 'Avoid pulling on the neck.', 'exercise' => 'Plank Variations', 'description' => 'Front and side planks.', 'duration' => '20 min'],
            ['category' => 'Functional', 'type' => 'Full Body', 'guideline' => 'Focus on form over speed.', 'exercise' => 'Kettlebell Swings', 'description' => 'Hinge at hips, snap hips forward.', 'duration' => '30 min'],
            ['category' => 'Cardio', 'type' => 'Endurance', 'guideline' => 'Stay in zone 2 heart rate.', 'exercise' => 'Incline Walk', 'description' => 'Treadmill 12% incline, brisk pace.', 'duration' => '40 min'],
            ['category' => 'Strength', 'type' => 'Pull', 'guideline' => 'Retract scapula before each pull.', 'exercise' => 'Lat Pulldown', 'description' => 'Wide grip, slow negative.', 'duration' => '40 min'],
            ['category' => 'Plyometric', 'type' => 'Power', 'guideline' => 'Land softly on box jumps.', 'exercise' => 'Box Jumps', 'description' => 'Step down between sets.', 'duration' => '25 min'],
            ['category' => 'Cooldown', 'type' => 'Stretch', 'guideline' => 'Hold each stretch 20–30 seconds.', 'exercise' => 'Full Body Stretch', 'description' => 'Hamstrings, quads, shoulders.', 'duration' => '10 min'],
        ];

        foreach ($exercises as $row) {
            Exercise::create($row);
        }

        $meals = [
            ['category' => 'Weight Loss', 'type' => 'Low Calorie', 'guideline' => 'Aim for high protein each meal.', 'day' => 'Monday', 'breakfast' => 'Oats with banana and egg whites', 'lunch' => 'Grilled chicken salad', 'dinner' => 'Baked fish with vegetables'],
            ['category' => 'Muscle Gain', 'type' => 'High Protein', 'guideline' => 'Eat every 3–4 hours.', 'day' => 'Tuesday', 'breakfast' => 'Eggs, toast, and Greek yogurt', 'lunch' => 'Beef sinigang with rice', 'dinner' => 'Pork adobo with brown rice'],
            ['category' => 'Maintenance', 'type' => 'Balanced', 'guideline' => 'Half plate vegetables.', 'day' => 'Wednesday', 'breakfast' => 'Tuna sandwich and fruit', 'lunch' => 'Chicken tinola', 'dinner' => 'Stir-fry tofu with veggies'],
            ['category' => 'Keto', 'type' => 'Low Carb', 'guideline' => 'Keep carbs under 50g daily.', 'day' => 'Thursday', 'breakfast' => 'Scrambled eggs with avocado', 'lunch' => 'Caesar salad with grilled salmon', 'dinner' => 'Steak with buttered broccoli'],
            ['category' => 'Vegetarian', 'type' => 'Plant Based', 'guideline' => 'Combine beans and rice for complete protein.', 'day' => 'Friday', 'breakfast' => 'Smoothie with spinach and protein powder', 'lunch' => 'Lentil soup and quinoa', 'dinner' => 'Veggie pasta with olive oil'],
            ['category' => 'Pre-Workout', 'type' => 'Energy', 'guideline' => 'Eat 60–90 minutes before training.', 'day' => 'Saturday', 'breakfast' => 'Rice cakes with peanut butter and banana', 'lunch' => 'Chicken wrap', 'dinner' => 'Light soup and salad'],
            ['category' => 'Post-Workout', 'type' => 'Recovery', 'guideline' => 'Protein within 30 minutes after gym.', 'day' => 'Sunday', 'breakfast' => 'Protein shake and papaya', 'lunch' => 'Tilapia with sweet potato', 'dinner' => 'Chicken breast with mixed greens'],
            ['category' => 'Weight Loss', 'type' => 'Meal Prep', 'guideline' => 'Prep containers on Sunday.', 'day' => 'Monday', 'breakfast' => 'Overnight chia pudding', 'lunch' => 'Turkey lettuce wraps', 'dinner' => 'Zucchini noodles with shrimp'],
            ['category' => 'Muscle Gain', 'type' => 'Bulking', 'guideline' => 'Add healthy fats for extra calories.', 'day' => 'Tuesday', 'breakfast' => 'Pancakes with peanut butter', 'lunch' => 'Double chicken burrito bowl', 'dinner' => 'Pasta with lean ground beef'],
            ['category' => 'General Health', 'type' => 'Filipino Fit', 'guideline' => 'Moderate rice portions.', 'day' => 'Wednesday', 'breakfast' => 'Champorado (small bowl) with milk', 'lunch' => 'Grilled bangus with ensaladang talong', 'dinner' => 'Chicken inasal with cucumber salad'],
        ];

        foreach ($meals as $row) {
            MealPlan::create($row);
        }

        $programs = [
            ['category' => 'Beginner', 'type' => 'Full Body', 'guideline' => '3 days per week, rest between days.', 'day' => 'Mon/Wed/Fri', 'workout' => 'Squat, push-up, row, plank', 'difficulty' => 'Easy', 'duration' => '45 min'],
            ['category' => 'Intermediate', 'type' => 'Upper/Lower', 'guideline' => 'Progressive overload each week.', 'day' => '4-day split', 'workout' => 'Bench, row, shoulder press, curls', 'difficulty' => 'Medium', 'duration' => '60 min'],
            ['category' => 'Advanced', 'type' => 'Push/Pull/Legs', 'guideline' => 'Track weights in a logbook.', 'day' => '6-day split', 'workout' => 'Heavy compounds + accessories', 'difficulty' => 'Hard', 'duration' => '75 min'],
            ['category' => 'Cardio', 'type' => 'Fat Burn', 'guideline' => 'Include 2 strength days.', 'day' => 'Daily cardio', 'workout' => 'Treadmill intervals + core', 'difficulty' => 'Medium', 'duration' => '40 min'],
            ['category' => 'Strength', 'type' => '5x5', 'guideline' => 'Add 2.5 kg when all sets complete.', 'day' => 'Mon/Wed/Fri', 'workout' => 'Squat, bench, deadlift, OHP, row', 'difficulty' => 'Medium', 'duration' => '50 min'],
            ['category' => 'Functional', 'type' => 'CrossFit Lite', 'guideline' => 'Scale movements as needed.', 'day' => 'Tue/Thu/Sat', 'workout' => 'AMRAP circuits and skill work', 'difficulty' => 'Hard', 'duration' => '55 min'],
            ['category' => 'Mobility', 'type' => 'Recovery', 'guideline' => 'Pair with rest days.', 'day' => 'Sunday', 'workout' => 'Yoga flow and foam rolling', 'difficulty' => 'Easy', 'duration' => '30 min'],
            ['category' => 'Home', 'type' => 'Bodyweight', 'guideline' => 'No equipment required.', 'day' => 'Any 3 days', 'workout' => 'Squats, lunges, dips, burpees', 'difficulty' => 'Easy', 'duration' => '35 min'],
            ['category' => 'Hypertrophy', 'type' => 'Bro Split', 'guideline' => '8–12 reps, 3–4 sets.', 'day' => '5-day split', 'workout' => 'Chest, back, legs, shoulders, arms', 'difficulty' => 'Medium', 'duration' => '65 min'],
            ['category' => 'Athlete', 'type' => 'Sport Performance', 'guideline' => 'Include plyometrics.', 'day' => 'Mon–Sat', 'workout' => 'Sprints, jumps, agility ladder', 'difficulty' => 'Hard', 'duration' => '70 min'],
        ];

        foreach ($programs as $row) {
            WorkoutProgram::create($row);
        }
    }

    private function seedMembershipPayments($members): void
    {
        foreach ($members->take(5) as $i => $member) {
            MembershipPayment::updateOrCreate(
                ['reference_number' => 'FITDROID-REF-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT)],
                [
                    'membership_id' => $member->id,
                    'gcash_number' => '0917123400' . $i,
                    'account_name' => $member->first_name . ' ' . $member->last_name,
                    'proof_of_payment_url' => 'sample/proof_' . ($i + 1) . '.jpg',
                ]
            );
        }
    }
}
