<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\Phone;
use App\Models\SubActivity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $buildingIds = [];

        foreach (range(1, 10) as $index) {
            $building = new Building();
            $building->address = fake()->streetAddress;
            $building->save();

            $this->setPoint(
                $building->id,
                rand(29000, 31000) / 1000,
                rand(59000, 61000) / 1000,
            );

            $buildingIds[] = $building->id;
        }

        $organisationIds = [];

        foreach (range(1, 30) as $index) {
            $organisation = new Organization();
            $organisation->building_id = $buildingIds[rand(1, count($buildingIds) - 1)];
            $organisation->name = 'OOO ' . fake()->sentence;
            $organisation->save();

            $organisationIds[] = $organisation->id;
        }

        foreach (range(1, 50) as $index) {
            $phone = new Phone();
            $phone->organization_id = $organisationIds[rand(1, count($organisationIds) - 1)];
            $phone->number = fake()->phoneNumber;
            $phone->save();
        }

        $activityIds = [];

        foreach (range(1, 10) as $index) {
            $activity = new Activity();
            $activity->organization_id = $organisationIds[rand(1, count($organisationIds) - 1)];
            $activity->name = fake()->sentence;
            $activity->save();

            $activityIds[] = $activity->id;
        }

        foreach (range(1, 30) as $index) {
            $activity = new SubActivity();
            $activity->activity_id = $activityIds[rand(1, count($activityIds) - 1)];
            $activity->name = fake()->sentence;
            $activity->save();
        }

        return 0;
    }

    /**
     * @param int   $id
     * @param float $longitude
     * @param float $latitude
     *
     * @return void
     */
    private function setPoint(int $id, float $longitude, float $latitude): void
    {
        $sql = "update buildings
            set location = ST_SetSRID(ST_MakePoint($longitude, $latitude), 4326)
            where id = $id;";

        DB::statement($sql);
    }
}
