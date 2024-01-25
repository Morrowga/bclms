<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use DateTime;
use HansSchouten\LaravelPageBuilder\LaravelPageBuilder;
use Src\BlendedConcept\System\Domain\Repositories\ReportRepositoryInterface;
use Src\BlendedConcept\Student\Infrastructure\EloquentModels\StudentEloquentModel;

class ReportRepository implements ReportRepositoryInterface
{
    public function reportExport()
    {
        $excels = [];

        $students = $this->checkUserType(auth()->user()->role->name);
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

    public function reportGame()
    {
        $excels = [];

        $students = $this->checkUserType(auth()->user()->role->name);
        foreach($students as $student){
            $gameAssignments = $student->gameAssignments; // Access the game assignments for each student
            foreach ($gameAssignments as $assignment) {
                array_push($excels, [
                    'Name' => $student->user->full_name,
                    'Gender' => $student->gender ?? '-',
                    'Device Used' => $student->device ? $student->device->name : '-',
                    'Game Name' => $assignment->game ? $assignment->game->name : '-',
                    'Score' => $assignment->score,
                    'Accuracy' => $assignment->accuracy,
                    'Duration' => $assignment->duration,
                ]);
            }
        }

        return $excels;
    }


    public function reportStorybook()
    {
        $excels = [];

        $students = $this->checkUserType(auth()->user()->role->name);
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

    public function checkUserType($role)
    {
        $excels = [];

        switch ($role) {
            case 'Organisation Admin':
                $students = StudentEloquentModel::where('organisation_id', auth()->user()->org_admin->organisation_id)->with(['device', 'gameAssignments.game'])->get();
                return $students;
                break;
            case 'B2C Parent':
                $students = StudentEloquentModel::where('parent_id', auth()->user()->parents->parent_id)->with(['device','gameAssignments.game'])->get();
                return $students;
                break;
            case 'Both Parent':
                $students = StudentEloquentModel::where('parent_id', auth()->user()->parents->parent_id)->with(['device','gameAssignments.game'])->get();
                return $students;
                break;
            case 'BC Subscriber':
                $students = auth()->user()->b2bUser->students;
                return $students;
                break;
            case 'Teacher':
                $students = [];
                $classrooms = auth()->user()->b2bUser->classrooms;
                if($classrooms != null){
                    foreach($classrooms as $classroom){
                        foreach($classroom->students as $student){
                            $students[] = $student;
                        }
                    }
                    return $students;
                }
                break;
            default:
                break;
        }

    }
}
