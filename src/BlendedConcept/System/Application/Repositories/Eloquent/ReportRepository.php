<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use DateTime;
use HansSchouten\LaravelPageBuilder\LaravelPageBuilder;
use Src\BlendedConcept\System\Domain\Repositories\ReportRepositoryInterface;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class ReportRepository implements ReportRepositoryInterface
{
    public function reportExport(){
        $students = StudentEloquentModel::where('organisation_id', auth()->user()->org_admin->organisation_id)->with(['device'])->get();

        $excels = [];

        foreach($students as $student){
            $data = [
                'Age of Child' => $this->calculateAge($student->dob),
                'Date of Birth' => $student->dob ?? '-',
                'Gender' => $student->gender ?? '-',
                'Level of Education' => $student->education_level,
                'Device Used' => $student->device ? $student->device->name : '-',
            ];
            $excels[] = $data;
        }

        return $excels;
    }

    private function calculateAge($birthdate){

        $birthdate = new DateTime($birthdate);

        $currentDate = new DateTime();

        $age = $birthdate->diff($currentDate);

        $years = $age->y;

        return $years;
    }
}
